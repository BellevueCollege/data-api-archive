#Classes API

The Classes API is a RESTful, read-only web service for accessing CTC ODS data in JSON format.

##API calls

These are the current endpoints that exist.

####Main

- `v1/courses/multiple?courses[]={courseid}&courses[]={courseid}...` - Uses `courses[]` query parameter in repeating fashion to specify multiple courses for which to have information returned.

- `v1/quarters/current` - Returns the current term/quarter.
    
####Modolabs-specific

- `v1/catalog/terms` - Return active/viewable terms/quarters

- `v1/catalog/terms/{YearQuarterID}` - Return term info for the specified term/quarter

- `v1/catalog/catalogAreas/{YearQuarterID}` - Return subjects offered for specified term/quarter

- `v1/catalog/{YearQuarterID}/{Subject}` - Return courses offered given specified term/quarter and subject/department

- `v1/catalog/{YearQuarterID}/{Subject}/{CourseNumber}` - Return specific course offered given term/quarter, subject/department, and course number


##Configuration

####config/app.php

 - `yearquarter_lookahead` - This is the number of days the application will look forward for terms/quarters with web registration opening.
 - `yearquarter_maxactive` - The number of YearQuarters that are active/viewable at a time.
 - `yearquarter_max` - The YearQuarterID of the maximum YearQuarter, currently set as _Z999_.
 - `timezone` - Your timezone, e.g. America/Los_Angeles or America/Denver. Used when building dates used in comparisons.
 - `common_course_char` - The character that designates a course as a common course.  Currently, _&_ is used in ODS (e.g. _ACCT& 201_).
 - `app_version` - The current application version.

####config/database.php
This is where you configure the connections to ODS (_ods_) and ClassSchedule (_cs_). Set the driver, host, port, database, etc, for each but do not change the names of the connections. When using SQL Server with named instances, you will likely need to use the IP address of the named instance.
 
##To do
The existing routes/endpoints and data transformation/serialization is currently very geared toward what is required by Modolabs. This API will likely evolve to abstract the transformation/serialization of the data from the controller functions that gather the data. In this way there is flexibility to have data wrapped and presented differently depending on the type of endpoint/call. 

##Terminology

###YearQuarter

A YearQuarter is used in the ODS and API to represent a quarter. Modolabs calls it a _term_. Data members of YearQuarter objects returned by the API.

####Modolabs
- `code` _string_
- `description` _string_

###Subject

A Subject is used in the ODS and API to represent a subject area courses are offered in.  Modolabs calls it a course area or area.

####Modolabs
- `area` _string_
- `code` _string_

###Course

A Course is general information about a course, non-specific to a quarter.

- `title` _string_
- `subject` _string_
- `courseNumber` _string_
- `description` _string_
- `note` _string_
- `credits` _string_
- `isVariableCredit` _bool_
- `isCommonCourse` _bool_ 

###CourseYearQuarter

A CourseYearQuarter is an offering of a course in a YearQuarter. ODS uses the term "Class" to hold this data, but that terminology is problematic in software.

####Modolabs

- `title` _string_
- `subject` _string_
- `courseNumber` _string_
- `description` _string_
- `note` _string_
- `credits` _string_
- `isVariableCredit` _bool_
- `isCommonCourse` _bool_ 
- `sections` _Section[]_

###Section

A Section is a section offering of a CourseYearQuarter. 

####Modolabs

- `crn` _string_
- `courseSection` _string_
- `instructor` _string_
- `beginDate` _string_ (datetime)
- `endDate` _string_ (datetime)
- `room` _string_
- `schedule` _string_

