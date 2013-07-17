Readme for CS336 Team 8's Special Permission Number System
By: Michael Cappelleri, John Cierpial, and Shashank Shankar

NOTE: Some machines have issues displaying the menu after logging in. If this is the case, zoom out by one (CTRL + -) and the menu should appear.

Features List:

General System Security:
User can only access pages which they are authorized for (ie: if student manually types in URL for Instructor or Admin pages, they receive a 403 Forbidden Error).

System Admin:
Load initial table of registrations/grades
Updates table of registrations/grades (if RUID: 1234 has grade for course entered as B and updated ASCII file indicates grade should be an A, the database's grade is updated to an A).
Load initial table of course offerings
Updates table of course offerings (again, course title, prereqs, netID of instructor, number of SPN #s available, or room size is changed in the ASCII file, the file can be reuploaded and the database values will be updated.)

Instructor:
Create account
Login
List of all courses offering SPNs for that professor only
	List contains: Course title, department number, course number, section number, room capacity, # of SPNs available to issue, and prerequisites for that course
Add courses and sections by hand
     Professor enters Course title, department number, course number, section number, room capacity, # of SPNs available to issue, and prerequisites for that course (each prereq is entered separated by a , ie: 198:205,198:211
Clicking a course allows professor to edit details of that course, as well as View SPN Requests and delete class from being offered

Communicate message to all students
    "Email this message to all on my waiting list"
	"Email this message to a specific student on my waiting list"
Handle updated enrollment lists
   If student is now enrolled, they are marked as "Already enrolled" on waiting list

Retrieve "active" student waiting list info, one line per student on screen (gives # of remaining SPN #s available to give and space left in classroom)
	Clicking request brings up user submitted info 
	Professor is able to type comments about request in textbox and save to DB for later viewing.
Simple built-in default formula ranking 
	(Works on a point system. Picks whoever has the most points. If the GPA is 4.0, they get 10 points. If it's > 3.0, they get 7 points. If it's > 2.0, they get 4 points. If it's > 1.0, they get 1 point.  If it's < 1.0, they get 0 points.  If the course is required, they get 5 points.  If you are not retaking the class, they get 5 points.  If you are graduating the following year, they get 5 points.)
By pressing Select Best Fit on View Requests page, professor is automatically brought to the request of the student with the highest priority (based on the above built-in default formula ranking).

Support Giving Special Permission Numbers
If there are no more SPN #s to give, or if there is no more room in the classroom, professor does not have option to accept requests.
Professor can enter SPN by hand
Professor can enter expiration date by hand
	If no expiration date specified, system takes current date and adds 3 days and sets expiration date as such.
If no SPN is defined or if SPN has already been assigned to someone else, an error message is given.
	However, if the expiration date has passed, and same SPN is assigned to another student, the system will let the number be assigned (since the first person's expiration date had passed).

Student:
Failed login
Create account
Succeed login
Request SP (get message)
Verify request there
Verify status (sp# given, denied, still waiting)
Logout
Handle prereqs
    Disallows request to be made if not currently registered in or completed prereqs (D or better)
    Drop request if F in prereq once completed