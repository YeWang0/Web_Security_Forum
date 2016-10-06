# Overview
Role-Based Access Control Forum(web) May.2016
 -Implemented the authorization management based on RBAC
 -Designed a super hash with multiple hash functions to secure user password
 -Integrated OAuth service(Gmail) for sign-up and login
 -Developed the website with PHP, JavaScript, JQuery, CSS and Bootstrap

## Dependence
Apache
PHP
## Run
	start Apache server
	run /UI/login.html 
## Guidance
 
Available users
    	username		role		    password<br />
    	evan        		admin			123<br />
	admin			admin			123<br />
	moderator1		moderator		123<br />
	moderator2		moderator		123<br />
	user1			user			123<br />	
	user2			user			123<br />
	author1			author			123<br />
	author2			author			123<br />

how to set user roles
    update users SET role_id='ID' where username='USERNAME';
    
roles id
    1 admin<br />
    2 author<br />
    3 moderator<br />
    4 user<br />
    
