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
	start apache server
	run /UI/login.html 
## Guidance
 
1. available users
    	username		role		    password
    	evan        		admin			123
	admin			admin			123
	moderator1		moderator		123
	moderator2		moderator		123
	user1			user			123	
	user2			user			123
	author1			author			123
	author2			author			123

2.how to set user roles
    update users SET role_id='ID' where username='USERNAME';
    
3. roles id
    1 admin
    2 author
    3 moderator
    4 user
    
