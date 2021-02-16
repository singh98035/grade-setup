<?php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "moodle";
   // Create connection
   $conn = new mysqli($servername, $username, $password, $dbname);

   // Check connection
   if ($conn->connect_error) 
   {
      die("Connection failed: " . $conn->connect_error);
   }
   echo "Connected successfully <br>";



 // fetching the course (course id) where we want to create categories
 $sql = "SELECT id FROM mdl_course";
 $result = $conn->query($sql);





   if ($result->num_rows > 0) // run when the number of records in mdl_course table is greater than zero
       {
         // output data of each row
         while($row = $result->fetch_assoc())
            {
                $course_id = $row["id"];

                //select the max id from categories table i.e 
                $sql1 = "SELECT id FROM mdl_grade_categories WHERE id=(SELECT max(id) FROM mdl_grade_categories) ";
                $result1 = $conn->query($sql1); //query executions
                  // select and count the number of duplicate records in categories table of ome course
                $sql3 = "SELECT COUNT(courseid) As total FROM mdl_grade_categories WHERE courseid = '$course_id'";
                $result3 = mysqli_query($conn , $sql3);
                $values = mysqli_fetch_assoc($result3);
                $num_row = $values['total'];

                 // if dupliacte number of records exist 
                if($num_row >= 1)
                  {
                     echo " <br>  already exist  <br>";
                     // if exist then check the parent category because if parent category create twice then there is error
                     $sql4 = "SELECT id FROM mdl_grade_categories WHERE courseid = '$course_id'  and fullname = '?'";
                     $result4 = $conn->query($sql4);
         
                     // if the course already exist then check duplicate records is less than 4 
                     if($num_row < 4)
                        {    
                           // if the already exist have parent record then only create sub categories not parent category 
                            if($result4->num_rows > 0)
                                 {

                                    // fetch output of query
                                    while($row = $result4->fetch_assoc())   
                                       {
                                          $update_courseid = $row["id"];
                  
                                          // show which course have already parent category and created only sub categories
                                          echo "<br>".$update_courseid. "update <br>";
               
                                          // fetch max id of table mdl_categories
                                          while($row = $result1->fetch_assoc())
                                             { //fetch max category id and assign to variable
                                                $categories_id = $row["id"];
                                                // mainly use for path because one course contain 4 records and set path to all categories
                                                $categories_id1 = $categories_id + 1; // if fetching max id is 6 than next record contain 7 number 
                                                $categories_id2 = $categories_id1 + 1;
                                                $categories_id3 = $categories_id2 + 1;
                                                $categories_id4 = $categories_id3 + 1;
   
                                                $sql2 = "INSERT INTO mdl_grade_categories (id, courseid, parent, depth, path, fullname, aggregation, keephigh, droplow, aggregateonlygraded, aggregateoutcomes, timecreated, timemodified, hidden)
                                                VALUES
                                                ($categories_id1, $course_id, $update_courseid, 2, '/$update_courseid/$categories_id1/', 'Assignment', 13, 0, 2, 1, 0, 1610102273, 1610102273, 0),
                                                ($categories_id2, $course_id, $update_courseid, 2, '/$update_courseid/$categories_id2/', 'MSE', 13, 0, 0, 1, 0, 1610102299, 1610102300, 0),
                                                ($categories_id3, $course_id, $update_courseid, 2, '/$update_courseid/$categories_id3/', 'Attendance', 13, 0, 0, 1, 0, 1610102317, 1610102317, 0)";
      
                                                if ( $result2 = $conn->query($sql2))
                                                      {
                                                         echo "<br> Inserted Successfully <br>";
                                                      }
                                                else
                                                      {
                                                         echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
                                                      }   
                                                break;  
                                             }
   
                                               break;
                                      }
                                 }
 
                      }

                } // it runs when no course categories already exist and all process is same
             elseif ($result1->num_rows > 0)
               {

                   while($row = $result1->fetch_assoc())
                    {
                     $categories_id = $row["id"];

                     $categories_id1 = $categories_id + 1;
                     $categories_id2 = $categories_id1 + 1;
                     $categories_id3 = $categories_id2 + 1;
                     $categories_id4 = $categories_id3 + 1;

                     $sql2 = "INSERT INTO mdl_grade_categories (id, courseid, parent, depth, path, fullname, aggregation, keephigh, droplow, aggregateonlygraded, aggregateoutcomes, timecreated, timemodified, hidden)
                      VALUES
                     ($categories_id1, $course_id, NULL, 1, '/$categories_id1/', '?', 13, 0, 0, 1, 0, 1610102166, 1610102166, 0),
                     ($categories_id2, $course_id, $categories_id1, 2, '/$categories_id1/$categories_id2/', 'Assignment', 13, 0, 2, 1, 0, 1610102273, 1610102273, 0),
                     ($categories_id3, $course_id, $categories_id1, 2, '/$categories_id1/$categories_id3/', 'MSE', 13, 0, 0, 1, 0, 1610102299, 1610102300, 0),
                     ($categories_id4, $course_id, $categories_id1, 2, '/$categories_id1/$categories_id4/', 'Attendance', 13, 0, 0, 1, 0, 1610102317, 1610102317, 0)";
   
                     if ( $result2 = $conn->query($sql2))
                           {
                              echo "<br> Inserted Successfully <br>";
                           }
                     else
                           {
                              echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
                           }   
                     break;  
                     }

   
    
               } // it runs when no record in table mdl_grade_categories
               elseif(empty($result1->num_rows))
                   {

                                                
                  // then no need to fetch max id because the table has no course just set the categoried_id varible to zero else all process is same for inserting
                     $categories_id = 0;



    
                     $categories_id1 = $categories_id + 1;
                     $categories_id2 = $categories_id1 + 1;
                     $categories_id3 = $categories_id2 + 1;
                     $categories_id4 = $categories_id3 + 1;
   
                     $sql2 = "INSERT INTO mdl_grade_categories (id, courseid, parent, depth, path, fullname, aggregation, keephigh, droplow, aggregateonlygraded, aggregateoutcomes, timecreated, timemodified, hidden)
                     VALUES
                     ($categories_id1, $course_id, NULL, 1, '/$categories_id1/', '?', 13, 0, 0, 1, 0, 1610102166, 1610102166, 0),
                     ($categories_id2, $course_id, $categories_id1, 2, '/$categories_id1/$categories_id2/', 'Assignment', 13, 0, 2, 1, 0, 1610102273, 1610102273, 0),
                     ($categories_id3, $course_id, $categories_id1, 2, '/$categories_id1/$categories_id3/', 'MSE', 13, 0, 0, 1, 0, 1610102299, 1610102300, 0),
                     ($categories_id4, $course_id, $categories_id1, 2, '/$categories_id1/$categories_id4/', 'Attendance', 13, 0, 0, 1, 0, 1610102317, 1610102317, 0)";
    
                      if ( $result2 = $conn->query($sql2))
                        {
                           echo " <br> Inserted Successfully <br>";
                        }
                     else
                        {
                           echo "Error: " . $sql2 . "<br>" . mysqli_error($conn);
                        }   
                  }

      
      

         
 
   else  
      {
         echo "0 result";
      }

             }

   }
   else {
       echo "0 results";
   }


?>