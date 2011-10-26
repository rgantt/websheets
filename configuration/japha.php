<?php
package("core");

/**
 * $Id: japha.php,v 1.1.1.1 2005/07/06 17:28:58 blargon Exp $
 *
 * The low level japha functionality for including packages and classes.
 *
 * To use the Japha library, all one has to do is include this file, and begin importing. Obviously some knowledge of
 * the Java 1.4.2 API would be beneficial, but it is not required, because using this file standalone could be very
 * valuable to any project. It includes semi-advanced inclusion techniques and runs at a VERY fast pace.
 *
 * If using this file standalone (seperate from the rest of the API), you may just think of it as include() on x, where
 * x is any drug that causes hyper-performance at low cost.
 *
 * Here are some benchmarks:
 *       All trials run 3 times, on the following import: org.apache.fulcrum.intake.IntakeServiceImpl
 *       There are 102 dependencies (direct and indirect), not counting resursive.
 *
 * BOX0: Athlon MP 2600+, 256 MB DDR
 *       Loaded 102 classes in 0.127, 0.152, 0.134 ms
 * BOX1: ??
 *       Loaded 102 classes in 0.095, 0.093, 0.097 ms
 *
 * When there is a call to the global import function, the following chain of excution ensues:
 *
 * 1) A simple regular expression in the function (keep regex out of classes, it's so ugly) determines whether
 *    or not the user is trying to import a package. If they aren't, then Japha::importQualifiedName() is called
 *    with the fully qualified name of the class as it's parameter. Otherwise, Japha::importQualifiedPackage() is
 *    called with the same value.
 * 2) Japha::importQualifiedName() will check to see whether the Japha super-system has been properly set-up and
 *    all of it's requisite classes loaded. If not, it makes a call to Japha::importRequired, which iterates through
 *    the array of system classes and includes them with a higher priority than the class that was originally passed
 *    to importQualifiedName()
 * 3) Once the required classes have been successfully loaded and verified, the hash code of the qualified name is 
 *    compared to the hash map of classes that have already been loaded. If a match is found ( in O(log n) ), then 
 *    the method returns. 
 * 4) If the method didn't return in step 3, a call to "require_once" is made, which will include the class no matter 
 *    what (assuming that it exists).
 * 5) The qualified name is then stripped of it's periods and hashed. This hash is added to the global "namespace", which
 *    is simply a giant hash map that includes all of the included classes. This step is performed to save time later by
 *    not importing the same file twice.
 * 6) At this point, the file has been succesfully included (there is a JaphaError thrown if a problem arose during the
 *    inclusion process), but there has been no step to make sure that that file actually had a class or interface in it.
 *    In the import() function (after steps 2-5 are completed), a call to Japha::assertLoaded() is made. 
 * 7) Though the implementation is sketchy at this point, it is known that this method will iterate through first the 
 *    array of PHP's  declared classes, and then it's array of declared interfaces looking for a definition with the same 
 *    name as the last segment of the fully qualified name. As of right now, this procedure is performed with the raw
 *    array returned by get_declared_classes/interfaces, which is very very very slow because of the sheer amount of
 *    classes in the namespace.
 *
 * to-do: Implement a hashing algorithm over the get_declared_classes/interfaces arrays returned by PHP to make the search
 *        times faster. The reason this is hard is because you would have to re-hash the entire array every time a new
 *        class was loaded to get the new array, which would actually take more time than it does now. If there were some
 *        way to only update the array for classes and interfaces that AREN'T already in the hash, then this just may
 *        work.
 *
 * @author Ryan Gantt
 * @version $Revision: 1.1.1.1 $
 */
class Japha
{
    /**
     * Classes that must be loaded with greatest priority (first).
     * These classes will thus not have to be loaded in user class files.
     *
     * @type String[]
     */
    private static $required = array( 
        "japha.lang.Object", 
        "japha.lang.Class",
        "japha.lang.String",
        "japha.lang.Throwable",
        "japha.lang.Error",
        "japha.lang.Exception",
        "japha.lang.RuntimeException",
        "japha.lang.System"
    );
    
    /**
     * The static instance of the Namespacing class;
     * Most of the actual work done in this class is abstracted through this instance.
     *
     * @type JaphaNamespace
     */
    private static $japha;
    
    /**
     * The static instance of the Classpathing class;
     * The classpaths are loaded from a file and inserted into an array which is private
     * to the class instance. When a qualified name is imported, it must be found under
     * one of the classpath entries from that file.
     *
     * @type JaphaClasspath
     */
    private static $cpath;
    
    /**
     * Internal flags used to decide whether or not it's safe to load the required classes
     *
     * If the byPass flag is set to any boolean true value, importQualifiedName will skip the loading of the required
     * classes, even if they haven't been loaded yet. This flag is ONLY used DURING the loading of the required classes
     * to avoid recursion conflicts (required classes are still loaded through importQualifiedName, so each one would
     * trigger the loading of all required classes if there was no flag set to avoid it.
     *
     * If the flag flag is set to any boolean true value, importQualifiedName will skip the loading of the required
     * classes, as well. However, this flag is set to true as soon as the required classes are successfully imported
     * and verified, AND it stays true once it has been changed.
     *
     * @type boolean
     */
    private static $flag = false;
    private static $byPass = false;
    
    /**
     * Imports the class or interface located in the fully qualified resource name "$qualifiedName"
     * Qualified names are in the format of xxx.package.path.to.ClassName
     *
     * First initializes the static instance of the Namespacing class (if hasn't been done)
     * Then checks if the flags are true, if not, it loads the requisite classes
     * Once a class is added, it is put into the namespace and can be resolved
     *
     * @param qualifiedName The fully qualified resource name of the class or interface
     * @return boolean true iff The qualified resource was either loaded or was already in the namespace
     */
    public static function importQualifiedName( $qualifiedName )
    {
        self::initNamespace();
        self::initClasspath();
        if( self::$flag || self::$byPass )
        {
            if( self::$japha->inMap( self::$japha->hashString( $qualifiedName ) ) )
            {
				/*
				echo 'Not adding '.$qualifiedName.' (';
				$ns = self::$japha->getNamespace();
				echo $ns[ self::$japha->hashString( $qualifiedName ) ].')<br/>';
				*/
                return true;
            }
            else
            {
                $resolved = str_replace( ".", "/", $qualifiedName ).".php";
                foreach( self::$cpath->getClasspath() as $key => $value )
                {
                    if( file_exists( $value."/".$resolved ) )
                    {
                        require_once( $value."/".$resolved );
                        return self::$japha->add( self::$japha->hashString( $qualifiedName ), $qualifiedName );   
                    }
                }
                throw new JaphaError("Could not find class in classpath! (<b>".$resolved."</b>)");
            }
        }
        self::importRequired();
    }
    
    /**
     * Creates a new static instance of the JaphaNamespace class
     */
    public static function initNamespace()
    {
        if( ! ( self::$japha instanceof JaphaNamespace ) )
        {
            self::$japha = new JaphaNamespace();   
        }   
    }
    
    /**
     * Creates a new static instance of the JaphaClasspath class
     */
    public static function initClasspath()
    {
        if( ! ( self::$cpath instanceof JaphaClasspath ) )
        {
            self::$cpath = new JaphaClasspath();   
        }
    }
    
    /**
     * Imports the required classes (executed before any user-level classes are imported)
     * If one or more of the classes was unsuccessfully loaded, a run-time exception is thrown,
     * which is then caught and displayed internally
     *
     * @throws JaphaError If the required resource files could not be loaded
     */
    public static function importRequired()
    {
        self::$byPass = true;
        foreach( self::$required as $key => $value )
        {
            self::importQualifiedName( $value );
        }
        if( !self::requiredInNameSpace() )
        {
            throw new JaphaError("Could not load required libraries");
        }
        self::$byPass = false;
        self::$flag = true;
    }

    /**
     * Calling this method after every import nearly doubles the exection time
     * It is necessary though, to make sure classes were properly imported
     *
     * @param qualifiedName The fully qualified resource name to assert was loaded
     * @throws JaphaError If the said resource was not contained in the file
     * @returns boolean true iff the file was both loaded and contained a class or interface definition
     */
    public static function assertLoaded( $qualifiedName )    
    {
        $names = explode( ".", $qualifiedName );
        $names = array_reverse( $names );
        if( self::isLoadedClass( $names[0] ) )
        {
            return true;   
        }
        else if( self::isLoadedInterface( $names[0] ) )
        {
            return true;
        }
        throw new JaphaError("Specified file was found, but it did not contain appropriate class or interface ( <b>".$qualifiedName."</b> )" );
    }

    /**
     * Can be used to check whether or not a loaded file actually contained a class
     * Good for preliminary error checking
     *
     * @param cls The fully qualified name of the class that should have been loaded
     * @return boolean true iff The qualified name was found in the class namespace
     */
    public static function isLoadedClass( $cls )
    {
        return self::$japha->isLoadedClass( $cls );
    }
    
    /**
     * Can be used to check whether or not a loaded file actually contained a interface
     * Good for preliminary error checking
     *
     * @param f The fully qualifed name of the interface that should have been loaded
     * @return boolean true iff The qualifed name was found in the interface namespace
     */
    public static function isLoadedInterface( $if )
    {
        return self::$japha->isLoadedInterface( $if );
    }
    
    /**
     * Iterates over the names of the required classes, and makes sure that they are in the namespace.
     * 
     * @return false If one or more of the classes was not in the namespace
     */
    public static function requiredInNamespace()
    {
        foreach( self::$required as $value )
        {
            if( !self::$japha->inMap( self::$japha->hashString( $value ) ) )
                return false;
        }
        return true;
    }
    
    /**
     * Adds a fully qualified entity name to the global namespace
     *
     * @param qualifiedName The fully qualified resource name to put into the global namespace
     * @return boolean Whether or not the qualified name was added to the namespace
     */
    public static function putQualifiedNameInNamespace( $qualifiedName )
    {
        return self::$japha->add( self::$japha->hashString( $qualifiedName ), $qualifiedName );
    }
    
    /**
     * Returns a raw copy of the physical namespace from the static instance of JaphaNamespace to the caller
     *
     * @return String[][] The entire namespace
     */
    public static function getNamespace()
    {
        return self::$japha->getNamespace();
    }
    
    public static function importQualifiedPackage( $qualifiedPackage )
    {
        $qualifiedPackage = str_replace( ".", "/", substr( $qualifiedPackage, 0, strlen( $qualifiedPackage ) - 2 ) );
        foreach( self::$cpath->getClasspath() as $value )
        {
            if( is_dir( $value."/".$qualifiedPackage ) )
            {
                $d = dir( $value."/".$qualifiedPackage );
            }
        }
        while( false !== ( $entry = $d->read() ) )
        {
            if( !ereg( "^\.", $entry ) && substr( $entry, -4, 4 ) == ".php" )
            {
                $qualifiedName = $qualifiedPackage."/".$entry;
                $qualifiedName = str_replace( ".php", "", $qualifiedName );
                self::importQualifiedName( str_replace( "/", ".", $qualifiedName ) );
            }
        }
    }
    
    public static function getClasspaths()
    {
        return self::$cpath->getClasspath();   
    }
    
    public static function declareQualifiedPackage( $qualifiedPackage )
    {
    /*
        make sure that there are no name collisions
        make sure that all resources in package are resolved
    */
    }
}

/**
 * $Id: japha.php,v 1.1.1.1 2005/07/06 17:28:58 blargon Exp $
 *
 *
 * @author <a href="mailto:gantt@cs.montana.edu">Ryan Gantt</a>
 * @version $Revision: 1.1.1.1 $
 */
class JaphaNamespace
{
    /**
     * An associative array that contains hash => name pairs
     * for each file that has been loaded by Japha
     *
     * @type String[][]
     */
    private $namespace;
    
    /**
     * An associated array that contains int => name pairs
     * for each class that exists within PHP's global namespace
     *
     * @type String[][]
     */
    private $classes;
    
    /**
     * An associated array that contains int => name pairs
     * for each interface that exists within PHP's global namespace
     *
     * @type String[][]
     */
    private $interfaces;
    
    /**
     * Constructor.
     *
     * Clears the global namespace
     */
    public function __construct()
    {
        $this->namespace = array();    
    }   

    /**
     * Grabs the global class and interface namespaces from PHP.
     * Should be run before every time you check for the existance of a class
     * or interface
     */
    public function refreshEntities()
    {
        $this->classes = get_declared_classes();
        $this->interfaces = get_declared_interfaces();   
    }
    
    public function isLoadedClass( $class )
    {
        return true;
    }
    
    public function isLoadedInterface( $interface )
    {
        return true;
    }
    
    /**
     * Adds a hash => name pair to the global namespace.
     * Note that strings are stripped of periods before they are hashed.
     *
     * @param name The hashed value of the value
     * @param value The fully qualified class name of the resource
     */
    public function add( $name, $value )
    {
        if( !is_numeric( $name ) )
        {
            $name = $this->hashString( $name );
        } 
        $this->namespace[ $name ] = $value;
    }
    
    /**
     * Checks whether or not the given key has a value within the namespace
     *
     * @param name The key of the value to search for (must be a hash)
     * @return boolean true iff The key exists and has a value within the namespace
     */
    public function inMap( $name )
    {
        return isset( $this->namespace[ $name ] );   
    }
    
    /**
     * Returns a hash for the given string, the same way every single time.
     *
     * Used for indexing the Namespace
     *
     * @param str The string to hash
     * @return long long int The hash code
     */
    public function hashString( $str )
    {
		return str_replace( '.', '', $str );
        $str = str_replace( ".", "", $str );
        $h = 1;
        for ( $i = 0; $i < strlen( $str ); $i++ ) 
        {
            $h = 2 * ( $h + ord( $str{ $i } ) );
        }
        return $h;
    }
    
    /**
     * Returns the physical namespace
     *
     * @returns String[][] The entities that have been loaded thusfar
     */
    public function getNamespace()
    {
        return $this->namespace;
    }
}

/**
 * $Id: japha.php,v 1.1.1.1 2005/07/06 17:28:58 blargon Exp $
 *
 * This class allows us to define multiple source directories that Japha can include from.
 * 
 * It loads the classPath directive from config.php (which is the only required directive in that file.
 *
 * @author <a href="mailto:gantt@cs.montana.edu">Ryan Gantt</a>
 * @version $Revision: 1.1.1.1 $
 */
class JaphaClasspath
{
    private $classpath = array();
    
    /**
     * Constructor.
     *
     * I do realize that it is very ugly to have global variables, but there are some things
     * that are more important than aethetics (such as being able to have more than one class path).
     */
    public function __construct()
    {
        if( is_file( dirname( __FILE__ ) . '/config.php' ) )
        {
            require_once dirname( __FILE__ ) . '/config.php';   
            $this->classpath = $classpath;
        }
        else
        {
            $this->classpath[0] = dirname( __FILE__ );   
        }
    }

    /**
     * Returns a raw instance array
     */
    public function getClasspath()
    {
        return $this->classpath;   
    }
}

/**
 * $Id: japha.php,v 1.1.1.1 2005/07/06 17:28:58 blargon Exp $
 *
 * @author <a href="mailto:gantt@cs.montana.edu">Ryan Gantt</a>
 * @version $Revision: 1.1.1.1 $
 */
class JaphaError extends Exception 
{
    /**
     * Constructor.
     *
     * Set's the parent's detail message parameter so that it can be grabbed later.
     *
     * @param message The detail error message of the Exception
     */
    public function __construct( $message )
    {
        $this->message = $message;
    }
    
    /**
     * Returns a string representation of the exception's error message
     *
     * @return String The detailed error message
     */
    public function toString()
    {
        echo $this->message.'<br/>';  
    }
}

/**
 * $Id: japha.php,v 1.1.1.1 2005/07/06 17:28:58 blargon Exp $
 *
 * Implement these.
 *
 * @author <a href="gantt@cs.montana.edu">Ryan Gantt</a>
 * @version $Revision: 1.1.1.1 $
 */
class SystemPropertyManager
{
    /**
     * Built-in system properties.
     * This can be extended by any arbitrary property that is set by a priveledged user.
     *
     * @type String[][]
     */
    private $properties = array(
        "japha.version" => "2.0.0",                 //Java Runtime Environment version
        "japha.emulation.version" => "1.4.2",       //Version of Java that Japha emulates
        "japha.vendor",                  //Java Runtime Environment vendor
        "japha.vendor.url",              //Java vendor URL
        "japha.home",                    //Java installation directory
        "japha.vm.specification.version",//Java Virtual Machine specification version
        "japha.vm.specification.vendor", //Java Virtual Machine specification vendor
        "japha.vm.specification.name",   //Java Virtual Machine specification name
        "japha.vm.version",              //Java Virtual Machine implementation version
        "japha.vm.vendor",               //Java Virtual Machine implementation vendor
        "japha.vm.name",                 //Java Virtual Machine implementation name
        "japha.specification.version",   //Java Runtime Environment specification version
        "japha.specification.vendor",    //Java Runtime Environment specification vendor
        "japha.specification.name",      //Java Runtime Environment specification name
        "japha.class.version",           //Java class format version number
        "japha.class.path",              //Java class path
        "japha.library.path",            //List of paths to search when loading libraries
        "japha.io.tmpdir",               //Default temp file path
        "japha.compiler",                //Name of JIT compiler to use
        "japha.ext.dirs",                //Path of extension directory or directories
        "os.name",                      //Operating system name
        "os.arch",                      //Operating system architecture
        "os.version",                   //Operating system version
        "file.separator",               //File separator ("/" on UNIX)
        "path.separator",               //Path separator (":" on UNIX)
        "line.separator",               //Line separator ("\n" on UNIX)    
        "user.name",                    //User's account name
        "user.home",                    //User's home directory
        "user.dir",                     //User's current working directory
    );
    
    public function __construct( $properties )
    {
        if( is_array( $properties ) )
        {
            foreach( $properties as $key => $value )
            {
                $this->properties[ $key ] = $value;   
            }   
        }
    }
    
    public function setProperty( $name, $value )
    {
        $this->properties[ $name ] = $value;   
    }
    
    public function getProperty( $name )
    {
        return new JaphaSystemProperty( $name, $this->properties[ $name ] );   
    }
}

class JaphaSystemProperty
{
    private $name;
    private $value;
    
    public function __construct( $name, $value=null )
    {
        $this->name = $name;
        $this->value = $value;   
    }   
    
    public function setName( $name )
    {
        $this->name = $name;   
    }
    
    public function setValue( $value )
    {
        $this->value = $value;   
    }
    
    public function getName()
    {
        return $this->name;   
    }
    
    public function getValue()
    {
        return $this->value;   
    }
    
    public function get()
    {
        return array( $this->name => $this->value );   
    }
}

/**
 * Declares a new qualified package in the global package namespace
 * Note that this is not functional as of yet
 *
 * @param pkg The qualified name of the package
 */
function package( $pkg )
{
	return Japha::declareQualifiedPackage(  $pkg );
} 

/**
 * Imported a fully qualified class name into the global namespace
 *
 * @param name The fully qualified resource name to import
 * @returns boolean true iff The resource was successfully loaded
 */
function import( $name )
{
    try
    {
        if( substr( $name, -1, 1 ) == '*' )
        {
            return Japha::importQualifiedPackage( $name );
        }
        Japha::importQualifiedName( $name );
        Japha::assertLoaded( $name );
    }
    catch( JaphaError $e )
    {
        $e->toString();
    }
}

/**
 * Returns the difference (in ms) between two different microtime() values
 * 
 * This was definitely one of the most valuable tools I used during the performance tuning stage.
 *
 * @param a The starting microtime()
 * @param b The ending microtime()
 * @returns float The difference (in ms) between the two times
 */
function microtime_diff( $a, $b )
{
    list( $a_dec, $a_sec ) = explode( ' ', $a );   
    list( $b_dec, $b_sec ) = explode( ' ', $b );
    return $b_sec - $a_sec + $b_dec - $a_dec;
}

function trace( $obj )
{
    echo '<pre>';
    print_r( $obj );
    echo '</pre>';   
}

function traced( $obj )
{
    trace( $obj );
    die();   
}

/**
 * This import is required to flush the static flags 
 *
 * It won't actually include the file, since Object is one of the requisite classes that is loaded during initializtion
 */
import('japha.lang.Object');

/**
 * A little easter egg for those who read the source code and know what to do. =] 
 */
if( isset( $_GET['JAPHA-31337-6047-34732'] ) )
{ 
    import('com.japha.native.core.Japhainfo'); 
    Japhainfo::credits(); 
    die(); 
}