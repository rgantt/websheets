<html>
<head>
<title>Date and Time Symbols</title>
</head>
<body>
<table>
  <tr>
    <th colspan="2">The following characters are recognized in the format string:</th>
  </tr>
  <tr>
    <td>a</td>
    <td>"am" or "pm"</td>
  </tr>
  <tr>
    <td>A</td>
    <td>"AM" or "PM"</td>
  </tr>
  <tr>
    <td>B</td>
    <td>Swatch Internet time</td>
  </tr>
  <tr>
    <td>d</td>
    <td>day of the month, 2 digits with leading zeros; i.e. "01" to "31"</td>
  </tr>
  <tr>
    <td>D</td>
    <td>day of the week, textual, 3 letters; e.g. "Fri"</td>
  </tr>
  <tr>
    <td>F</td>
    <td>month, textual, long; e.g. "January"</td>
  </tr>
  <tr>
    <td>g</td>
    <td>hour, 12-hour format without leading zeros; i.e. "1" to "12"</td>
  </tr>
  <tr>
    <td>G</td>
    <td>hour, 24-hour format without leading zeros; i.e. "0" to "23"</td>
  </tr>
  <tr>
    <td>h</td>
    <td>hour, 12-hour format; i.e. "01" to "12"</td>
  </tr>
  <tr>
    <td>H</td>
    <td>hour, 24-hour format; i.e. "00" to "23"</td>
  </tr>
  <tr>
    <td>i</td>
    <td>minutes; i.e. "00" to "59"</td>
  </tr>
  <tr>
    <td>I</td>
    <td>(captial i)"1" if Daylight Savings Time, "0" otherwise.</td>
  </tr>
  <tr>
    <td>j</td>
    <td>ay of the month without leading zeros; i.e. "1" to "31"</td>
  </tr>
  <tr>
    <td>l</td>
    <td>(lowercase 'L') - day of the week, textual, long; e.g. "Friday"</td>
  </tr>
  <tr>
    <td>L</td>
    <td>boolean for whether it is a leap year; i.e. "0" or "1"</td>
  </tr>
  <tr>
    <td>m</td>
    <td>month; i.e. "01" to "12"</td>
  </tr>
  <tr>
    <td>M</td>
    <td>month, textual, 3 letters; e.g. "Jan"</td>
  </tr>
  <tr>
    <td>n</td>
    <td>month without leading zeros; i.e. "1" to "12"</td>
  </tr>
  <tr>
    <td>O</td>
    <td>Difference to Greenwich time in hours; e.g. "+0200"</td>
  </tr>
  <tr>
    <td>r</td>
    <td>RFC 822 formatted date; e.g. "Thu, 21 Dec 2000 16:01:07 +0200" (added in PHP 4.0.4)</td>
  </tr>
  <tr>
    <td>s</td>
    <td>seconds; i.e. "00" to "59"</td>
  </tr>
  <tr>
    <td>S</td>
    <td>English ordinal suffix for the day of the month, 2 characters; i.e. "st", "nd", "rd" or "th"</td>
  </tr>
  <tr>
    <td>t</td>
    <td>number of days in the given month; i.e. "28" to "31"</td>
  </tr>
  <tr>
    <td>T</td>
    <td>Timezone setting of this machine; e.g. "EST" or "MDT"</td>
  </tr>
  <tr>
    <td>U</td>
    <td>seconds since the Unix Epoch (January 1 1970 00:00:00 GMT)</td>
  </tr>
  <tr>
    <td>w</td>
    <td>day of the week, numeric, i.e. "0" (Sunday) to "6" (Saturday)</td>
  </tr>
  <tr>
    <td>W</td>
    <td>ISO-8601 week number of year, weeks starting on Monday (added in PHP 4.1.0)</td>
  </tr>
  <tr>
    <td>Y</td>
    <td>year, 4 digits; e.g. "1999"</td>
  </tr>
  <tr>
    <td>y</td>
    <td>year, 2 digits; e.g. "99"</td>
  </tr>
  <tr>
    <td>z</td>
    <td>day of the year; i.e. "0" to "365"</td>
  </tr>
  <tr>
    <td>Z</td>
    <td>timezone offset in seconds (i.e. "-43200" to "43200"). The offset for timezones west of UTC is always negative, and for those east of UTC is always positive.</td>
  </tr>
  <tr>
    <td colspan="2">Unrecognized characters in the format string will be printed as-is.</td>
  </tr>
  <tr>
    <td colspan="2">An example of a time would be: " M-d-Y ".</td>
  </tr>
</table>
</body>
</html>