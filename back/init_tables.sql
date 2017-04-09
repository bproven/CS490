/* 
 *     File:    init_tables.sql
 *     Author:  Bob
 *     Created: Apr 9, 2017
 */

insert into `cs490_question` 
    values  
            (1,'Write a function named cubed that returns the cube of the passed in float\n','float',null,null,null,'float',0,'cubed',0,0,0,0),
            (2,'Write a function named add that returns the sum of two floats.','float','float',null,null,'float',0,'add',0,0,0,0),
            (3,'Write a function named multiply that multiplies two floats and returns the result.','float','float',null,null,'float',0,'multiply',0,0,0,0),
            (4,'Write a function named square that returns the square of the passed in integer.','int',null,null,null,'int',0,'square',0,0,0,0),
            (5,'Using recursion, write a function named sum that returns the sum of the numbers from 1 to the passed in integer.','int',null,null,null,'int',2,'sum',0,0,0,1),
            (6,'Using a while loop, write a function named fact that returns the factorial of the passed in integer.','int',null,null,null,'int',1,'fact',0,1,0,0),
            (7,'Using if statements, write a function named binaryOp that takes a float, string operator and another float and returns the result.','float','String','float',null,'float',1,'binaryOp',1,0,0,0),
            (8,"Using a for loop, write a function named power that returns the first integer to the second's power.",'int','int',null,null,'int',1,'power',0,0,1,0);

alter table cs490_question 
    auto_increment = 9;

insert into `cs490_testcase` 
    values 
        (1,1,'-2',null,null,null,'-8'),
        (2,1,'-1',null,null,null,'-1'),
        (3,1,'0',null,null,null,'0'),
        (4,1,'1',null,null,null,'1'),
        (5,1,'2',null,null,null,'8'),

        (6,2,'-1','-1',null,null,'-2'),
        (7,2,'-1','0',null,null,'-1'),
        (8,2,'0','0',null,null,'0'),
        (9,2,'0','1',null,null,'1'),
        (10,2,'1','1',null,null,'2'),

        (11,3,'-2','-2',null,null,'4'),
        (12,3,'-2','-1',null,null,'2'),
        (13,3,'-2','0',null,null,'0'),
        (14,3,'-2','1',null,null,'-2'),
        (15,3,'-2','2',null,null,'-4'),

        (16,3,'-1','-1',null,null,'1'),
        (17,3,'-1','0',null,null,'0'),

        (18,3,'1','-1',null,null,'-1'),
        (19,3,'1','0',null,null,'0'),
        (20,3,'1','1',null,null,'1'),

        (21,3,'2','-1',null,null,'-2'),
        (22,3,'2','0',null,null,'0'),
        (23,3,'2','1',null,null,'2'),

        (24,4,'-2',null,null,null,'4'),
        (25,4,'-1',null,null,null,'1'),
        (26,4,'0',null,null,null,'0'),
        (27,4,'1',null,null,null,'1'),
        (28,4,'2',null,null,null,'4'),

        (29,5,'1',null,null,null,'1'),
        (30,5,'2',null,null,null,'3'),
        (31,5,'3',null,null,null,'6'),
        (32,5,'4',null,null,null,'10'),

        (33,6,'0',null,null,null,'1'),
        (34,6,'1',null,null,null,'1'),
        (35,6,'2',null,null,null,'2'),
        (36,6,'3',null,null,null,'6'),
        (37,6,'4',null,null,null,'24'),

        (38,7,'-1','*','-1',null,'1'),
        (39,7,'-1','*','0',null,'0'),
        (40,7,'-1','*','1',null,'-1'),
        (41,7,'0','*','0',null,'0'),
        (42,7,'0','*','1',null,'0'),
        (43,7,'1','*','1',null,'1'),

        (44,7,'-1','+','-1',null,'-2'),
        (45,7,'-1','+','0',null,'-1'),
        (46,7,'-1','+','1',null,'0'),
        (47,7,'0','+','0',null,'0'),
        (48,7,'0','+','1',null,'1'),
        (49,7,'1','+','1',null,'2'),

        (50,7,'-1','/','-1',null,'1'),
        (51,7,'-1','/','1',null,'-1'),
        (52,7,'0','/','1',null,'0'),
        (53,7,'1','/','1',null,'1'),

        (54,7,'10','%','3',null,'1'),
        (55,7,'9','%','3',null,'0'),
        (56,7,'8','%','3',null,'2'),
        (57,7,'7','%','3',null,'1'),
        (58,7,'6','%','3',null,'0'),

        (59,8,'-2','0',null,null,'1'),
        (60,8,'-2','1',null,null,'-2'),
        (61,8,'-2','2',null,null,'4'),
        (62,8,'-2','3',null,null,'-8'),
        (63,8,'-1','0',null,null,'1'),
        (64,8,'-1','1',null,null,'-1'),
        (65,8,'-1','2',null,null,'1'),
        (66,8,'-1','3',null,null,'-1'),
        (67,8,'1','0',null,null,'1'),
        (68,8,'1','1',null,null,'1'),
        (69,8,'1','2',null,null,'1'),
        (70,8,'1','3',null,null,'1'),
        (71,8,'2','0',null,null,'1'),
        (72,8,'2','1',null,null,'2'),
        (73,8,'2','2',null,null,'4'),
        (74,8,'2','3',null,null,'8');

alter table cs490_testcase 
    auto_increment = 75;

insert into `cs490_exam` 
    values 
        (1,'CS 101','taj1'),
        (2,'CS 102','taj1');

alter table cs490_exam 
    auto_increment = 3;

insert into `cs490_examquestion` 
    values 
        (1,1),
        (1,2),
        (1,3),
        (1,4),
        (1,5),
        (1,6),
        (1,7),
        (1,8),
        (2,1),
        (2,2),
        (2,3);

insert into `cs490_examquestionanswer` 
    values 
        ('rap9',1,1,'public static float cube( float number )\n{\n    return number * number * number;\n}'),
        ('rap9',1,2,'public static float add( float a, float b )\n{\n    return a + b;\n}'),
        ('rap9',1,3,'public static float multiply( float a, float b )\n{\n    return a * b;\n}'),
        ('rap9',1,4,'public static int squar( int number )\n{\n    return number * number;'),
        ('rap9',1,5,'public static int sum( int number ) \n{ \n    int result;\n    if ( number <= 1 ) \n    { \n        result = 1; \n    } \n    else \n    { \n        result = number + seq( number - 1 ); \n    } \n    return result;\n}'),
        ('rap9',1,6,'public static int fact( int number ) \n{ \n    int result = 1; \n    int n = 0; \n    while ( n <= number ) \n    { \n        result = result * n \n    } \n    return result; \n}'),
        ('rap9',1,7,'public static float binaryOp( float arg1, string op, float arg2 ) \n{ \n    float result = 0.0; \n    if ( op == \"+\" ) \n    { \n        result = arg1 + arg2;\n    } \n    else if ( op == \"*\" ) \n    { \n        result = arg1 * arg2;\n    } \n    else if ( op == \"/\" ) \n    { \n        result = arg1 / arg2; \n    } \n    else if ( op == \"%\" ) \n    { \n        result = arg1 % arg2; \n    } \n    return result; \n}'),
        ('rap9',1,8,'public static int power( int arg1, int arg2 ) \n{ \n    int result = arg1; \n    for ( int p = 2; p <= arg2; p++ ) \n    {\n        result = result * arg1; \n    }\n    return result;\n}');

insert into `cs490_studentexamquestionfeedback` 
    values 
        ( 1,'rap9',1,1,'Function Name',0,0,1),
        ( 2,'rap9',1,1,'Compilation  ',0,0,1),
        ( 3,'rap9',1,2,'Function Name',1,1,1),
        ( 4,'rap9',1,2,'Compilation  ',0,0,1),
        ( 5,'rap9',1,3,'Function Name',1,1,1),
        ( 6,'rap9',1,3,'Compilation  ',0,0,1),
        ( 7,'rap9',1,4,'Function Name',0,0,1),
        ( 8,'rap9',1,4,'Compilation  ',0,0,1),
        ( 9,'rap9',1,5,'Function Name',1,1,1),
        (10,'rap9',1,5,'Compilation  ',0,0,1),
        (11,'rap9',1,6,'Function Name',1,1,1),
        (12,'rap9',1,6,'Compilation  ',0,0,1),
        (13,'rap9',1,7,'Function Name',1,1,1),
        (14,'rap9',1,7,'Compilation  ',0,0,1),
        (15,'rap9',1,8,'Function Name',1,1,1),
        (16,'rap9',1,8,'Compilation  ',0,0,1);

alter table cs490_studentexamquestionfeedback 
    auto_increment = 17;

insert into `cs490_studentexamquestionscore` 
    values 
        ('rap9',1,1,0,2),
        ('rap9',1,2,1,2),
        ('rap9',1,3,1,2),
        ('rap9',1,4,0,2),
        ('rap9',1,5,1,2),
        ('rap9',1,6,1,2),
        ('rap9',1,7,1,2),
        ('rap9',1,8,1,2);

insert into `cs490_studentexamscore` 
    values 
        ('rap9',1,6,16);
