# Gaming-Weblog
A Custom Weblog for Gamers. 
This blog has following use cases:
 
- Blog owners can sign up, log in and log out.
- Blog has initially a single Admin user and the initial role of the other users when first sign up (register) in the blog, would be Ordinary user.
- Admin(s) can change role of other users to any of Admin, Moderator, Author or Ordinary user. The first three roles are considered as bloggers.
- Bloggers can post new blog POSTS, edit them and delete them.
- Some bloggers can also dynamically create/edit/delete PAGES (pages are different from posts since content of each page will be shown on a separate web page). Each page has its short title, long title and content. A link to each page will be shown in the blog menu. The text of this link would be the short title of the page.
- Each Blog post can have a single category and multiple tags
- All visiting users can submit comments on every blog post and can rate the blog posts / pages.
- Bloggers can review user comments before being published and confirm it to be shown under the post or reject it from being shown.
- In the main page (posts view page) the last N posts are shown (newer posts are shown first). N can be adjusted in the application settings page.
- If more than N posts exists in the posts view page, then you must provide pagination (links or other methods which allow user to see previous N posts)
- Admins: which have access and permission to all actions/operations Defined with role 0.
- Moderators: which have all the access but can not add new users to the blog and can not change the role of users  Defined with role 1.
- Authors: which just can write/edit posts but can not create pages  Defined with role 2.
- Ordinary users: which can just visit and rate posts/pages and submit their comments. the difference between a signed in Ordinary user and a user which has not signed in is that when user wants to send a comment, his/her info (name, ...) will be loaded in the comment form from the loged in account  Defined with role 3.
