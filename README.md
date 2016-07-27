CSV To SQL Mapper POC
=====================

Simple proof of concept demo of converting CSV data in to SQL.

The converter expects the data to be in the following format:

    Form,Question,Type,Multiple Choice,Answers
    Test Form,Test Question,1,0,"Ans 1,Ans 2,Ans 3"
    Test Form,Test Question 2,1,0,"Ans 1 - 2,Ans 2 - 2,Ans 3 - 2"
    Test Form 2,Test Question 3,1,0,"Ans 1,Ans 2,Ans 3"
    Test Form 2,Test Question 4,2,0,

And it will generate matching SQL