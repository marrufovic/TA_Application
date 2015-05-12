<!--
Author: Victor Marrufo
Date: 02/05/15
Purpose: Provided information about designing desicions
-->

<!DOCTYPE html>
<html>
<head>
        <link rel="stylesheet" type="text/css" href="../../style.css">
</head>
<body>

<?php
include_once("Required/header.php");
echo($header);
?>

<h1>TA3 Schema</h1>

<div id="main">

<h2>Original Schema</h2>
<h3>Users</h3>
idusers++
<br>
name
<br>
email(unique)
<br>
password
<br>
uid

<h3>Role</h3>
rolesid++
<br>
idusers(foreign)
<br>
role

<h3>Applications</h3>
app_id++
<br>
idusers(foreign)
<br>
GPA
<br>
app_date
<br>
version_number

<h3>Desired Courses</h3>
desired_coursesid++
<br>
idusers(foreign)
<br>
course_id(foreign)
<br>
prior_TA
<br>
complete_at_u

<h3>Offered Courses</h3>
offered_course_id++
<br>
course_id(foreign)
<br>
idusers(foreign)
<br>
semester
<br>
year
student_count
<br>
TA_count

<h3>Course Information</h3>
course_id++
<br>
department
<br>
course_number
<br>
course_name
<br>
description

<h2>Schema Modifications Based on Peer Review</h2>

<h3>Users</h3>
idusers++
<br>
name
<br>
email(unique)
<br>
password
<br>
uid

<h3>Role</h3>
rolesid++
<br>
idusers(foreign)
<br>
role

<h3>Applications</h3>

app_id++
<br>
idusers(foreign)
<br>
GPA
<br>
Hours AvailableAvailable First Week?
<br>
app_date
<br>
version_number

<h3>Desired Courses</h3>

desired_coursesid++
<br>
idusers(foreign)
<br>
course_id(foreign)
<br>
prior_TA
<br>
complete_at_u

<h3>Offered Courses</h3>

offered_course_id++
<br>
course_id(foreign)
<br>
idusers(foreign)
<br>
semester
<br>
year
<br>
student_count
<br>
TA_count

<h3>Course Information</h3>

course_id++
<br>
department
<br>
course_number
<br>
course_name
<br>
description

</div>

<div id="footer">
        <p>Created by Victor Marrufo</p>
</div>

</body>
</html>
