# grade-setup
## steps to create categories in all course
1. For creating categories make sure course is created first.
2. Each course have 4 records of categories means one is parent and other is sub categories because the path of sub categories is dependent on parent category.
3. if the parent categories exist in the database table then the code not creating the parent only create sub categories.
4. if the course is new no parent category available in category table it creates parent and sub categories.
5. firstly set the code means the code is familier with your database name, host, username and password.
6. first test on testing course if the test is successfull then run the code on original data.
7. if any error occured in test then remove the error and run again.
8. otherwise categories created in all course automatically.
9. for view the categories on frontend first goto your course then click on grade setup or grade view.   
