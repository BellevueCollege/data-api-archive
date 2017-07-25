# Bellevue College Data API

The Data API is a RESTful, read-only web service for accessing Bellevue College data in JSON format.

## API Endpoints

### Class data

- `v1/courses/multiple?courses[]={courseid}&courses[]={courseid}...` - Uses `courses[]` query parameter in repeating fashion to specify multiple courses for which to have information returned.

- `v1/quarters/current` - Returns the current term/quarter.
    
#### Modolabs-specific endpoints

- `v1/catalog/terms` - Return active/viewable terms/quarters

- `v1/catalog/terms/{YearQuarterID}` - Return term info for the specified term/quarter

- `v1/catalog/catalogAreas/{YearQuarterID}` - Return subjects offered for specified term/quarter

- `v1/catalog/{YearQuarterID}/{Subject}` - Return courses offered given specified term/quarter and subject/department

- `v1/catalog/{YearQuarterID}/{Subject}/{CourseNumber}` - Return specific course offered given term/quarter, subject/department, and course number

### People data

- `v1/auth/login` - The endpoint to authenticate and retrieve a valid token so protected data endpoints can be used.

- `v1/employee/{username}` - Return basic employee information given a username _(protected)_

- `v1/student/{username}` - Return basic student information given a username _(protected)_

## Configuration

#### config/app.php

 - `yearquarter_lookahead` - This is the number of days the application will look forward for terms/quarters with web registration opening.
 - `yearquarter_maxactive` - The number of YearQuarters that are active/viewable at a time.
 - `yearquarter_max` - The YearQuarterID of the maximum YearQuarter, currently set as _Z999_.
 - `timezone` - Your timezone, e.g. America/Los_Angeles or America/Denver. Used when building dates used in comparisons.
 - `common_course_char` - The character that designates a course as a common course.  Currently, _&_ is used in ODS (e.g. _ACCT& 201_).
 - `app_version` - The current application version.

#### config/database.php
This is where you configure the connections to ODS (_ods_) and ClassSchedule (_cs_). Set the driver, host, port, database, etc, for each but do not change the names of the connections. When using SQL Server with named instances, you will likely need to use the IP address of the named instance.

#### config/auth.php
Authentication configuration for Lumen, including defaults and type of defaults and user provider to use.

#### config/jwt.php
This is the configuration for jwt-auth. It shouldn't need to be edited.

### .env
The .env file has a number of values you may want to tweak depending on what you're setting up.

 - `APP_ENV` - Values `local`, `staging`, `production`
 - `APP_DEBUG` - Values `true`, `false` (should always be false in production)
 - `JWT_SECRET` - The secret generated when setting up jwt-auth
 - `CACHE_DRIVER` - Options available depend on what you've included in project. `file` should always work. `memcached` or `redis` could be other options depending on what packages you've set up.

## Authentication

Some of the data endpoints are protected and require authentication to use. If your application requires use of these endpoints, you will need to be issued a clientid and clientkey. When you log in with these, you will be returned a token that is valid for the configured amount of time (60 minutes by default).

Example `curl` authentication:

```
curl -i https://localhost/v1/auth/login -d clientid={clientid} -d clientkey={clientkey}
```

Example WordPress/PHP authentication:

```php
$body = array('clientid' => $clientid, 'clientkey' => $clientkey);
$auth_url = 'https://localhost/v1/auth/login';
$resp = wp_remote_post($auth_url, array(
                        'method' => 'POST', 'sslverify' => true,
                        'body' => $body));
```

A web token will be returned to you with a successful login. Include this bearer token in the header of your data request.

Example `curl` request with token:

```
curl -H "Authorization: Bearer {token}" https://localhost/v1/student/student.test
```

Example WordPress/PHP request with token:

```
$headers = array('Authorization' => 'Bearer ' . $token);

$resp = wp_remote_get( 'https://localhost/v1/student/student.test', array( 'headers' => $headers, 'sslverify' => true ) );
```

## To Do
The existing routes/endpoints and data transformation/serialization for class data is currently very geared toward what is required by Modolabs. This API will likely evolve to abstract the transformation/serialization of the data from the controller functions that gather the data. In this way there is flexibility to have data wrapped and presented differently depending on the type of endpoint/call. 

## Terminology

For explanation on terminology/objects used in the DataAPI, [refer to the terminology documentation](terminology.md).