/* 
 *     File:    init_tables.sql
 *     Author:  Bob
 *     Created: Apr 9, 2017
 */

--
-- Dumping data for table `cs490_question`
--

INSERT INTO `cs490_question` 
    VALUES  
            (1,'Write a function named cubed that returns the cube of the passed in float\n','float',NULL,NULL,NULL,'float',0,'cubed',0,0,0,0),
            (2,'Write a function named sum that returns the sum of two floats.','float','float',NULL,NULL,'float',0,'sum',0,0,0,0),
            (3,'Write a function named multiply that multiplies two floats and returns the result.','float','float',NULL,NULL,'float',0,'multiply',0,0,0,0),
            (4,'Write a function named square that returns the square of the passed in integer.','int',NULL,NULL,NULL,'int',0,'square',0,0,0,0),
            (5,'Using recursion, write a function named seq that returns the numbers from 1 to the passed in integer.','int',NULL,NULL,NULL,'int',2,'seq',0,0,0,1),
            (6,'Using a while loop, write a function named fact that returns the factorial of the passed in integer.','int',NULL,NULL,NULL,'int',1,'fact',0,1,0,0),
            (7,'Using if statements, write a function named binaryOp that takes a float, srting operator and another float and returns the result.','float','String','float',NULL,'float',1,'binaryOp',1,0,0,0),
            (8,"Using a for loop, write a function named power that returns the first integer to the second's power.",'int','int',NULL,NULL,'int',1,'power',0,0,1,0);

INSERT INTO `cs490_testcase` 
    VALUES 
        (1,1,'-2',NULL,NULL,NULL,'-8'),
        (2,1,'-1',NULL,NULL,NULL,'-1'),
        (3,1,'0',NULL,NULL,NULL,'0'),
        (4,1,'1',NULL,NULL,NULL,'1'),
        (5,1,'2',NULL,NULL,NULL,'8'),

        (6,2,'-1','-1',NULL,NULL,'-2'),
        (7,2,'-1','0',NULL,NULL,'-1'),
        (8,2,'0','0',NULL,NULL,'0'),
        (9,2,'0','1',NULL,NULL,'1'),
        (10,2,'1','1',NULL,NULL,'2'),

        (11,3,'-2','-2',NULL,NULL,'4'),
        (12,3,'-2','-1',NULL,NULL,'2'),
        (13,3,'-2','0',NULL,NULL,'0'),
        (14,3,'-2','1',NULL,NULL,'-2'),
        (15,3,'-2','2',NULL,NULL,'-4'),

        (16,3,'-1','-1',NULL,NULL,'1'),
        (17,3,'-1','0',NULL,NULL,'0'),

        (18,3,'1','-1',NULL,NULL,'-1'),
        (19,3,'1','0',NULL,NULL,'0'),
        (20,3,'1','1',NULL,NULL,'1'),

        (21,3,'2','-1',NULL,NULL,'-2'),
        (22,3,'2','0',NULL,NULL,'0'),
        (23,3,'2','1',NULL,NULL,'2'),

        (24,4,'-2',NULL,NULL,NULL,'4'),
        (25,4,'-1',NULL,NULL,NULL,'1'),
        (26,4,'0',NULL,NULL,NULL,'0'),
        (27,4,'1',NULL,NULL,NULL,'1'),
        (28,4,'2',NULL,NULL,NULL,'4'),

        (29,5,'1',NULL,NULL,NULL,'1'),
        (30,5,'2',NULL,NULL,NULL,'3'),
        (31,5,'3',NULL,NULL,NULL,'6'),
        (32,5,'4',NULL,NULL,NULL,'10'),

        (33,6,'0',NULL,NULL,NULL,'1'),
        (34,6,'1',NULL,NULL,NULL,'1'),
        (35,6,'2',NULL,NULL,NULL,'2'),
        (36,6,'3',NULL,NULL,NULL,'6'),
        (37,6,'4',NULL,NULL,NULL,'24'),

        (38,7,'-1','*','-1',NULL,'1'),
        (39,7,'-1','*','0',NULL,'0'),
        (40,7,'-1','*','1',NULL,'-1'),
        (41,7,'0','*','0',NULL,'0'),
        (42,7,'0','*','1',NULL,'0'),
        (43,7,'1','*','1',NULL,'1'),

        (44,7,'-1','+','-1',NULL,'-2'),
        (45,7,'-1','+','0',NULL,'-1'),
        (46,7,'-1','+','1',NULL,'0'),
        (47,7,'0','+','0',NULL,'0'),
        (48,7,'0','+','1',NULL,'1'),
        (49,7,'1','+','1',NULL,'2'),

        (50,7,'-1','/','-1',NULL,'1'),
        (51,7,'-1','/','1',NULL,'-1'),
        (52,7,'0','/','1',NULL,'0'),
        (53,7,'1','/','1',NULL,'1'),

        (54,7,'10','%','3',NULL,'1'),
        (55,7,'9','%','3',NULL,'0'),
        (56,7,'8','%','3',NULL,'2'),
        (57,7,'7','%','3',NULL,'1'),
        (58,7,'6','%','3',NULL,'0'),

        (59,8,'-2','0',NULL,NULL,'1'),
        (60,8,'-2','1',NULL,NULL,'-2'),
        (61,8,'-2','2',NULL,NULL,'4'),
        (62,8,'-2','3',NULL,NULL,'-8'),
        (63,8,'-1','0',NULL,NULL,'1'),
        (64,8,'-1','1',NULL,NULL,'-1'),
        (65,8,'-1','2',NULL,NULL,'1'),
        (66,8,'-1','3',NULL,NULL,'-1'),
        (67,8,'1','0',NULL,NULL,'1'),
        (68,8,'1','1',NULL,NULL,'1'),
        (69,8,'1','2',NULL,NULL,'1'),
        (70,8,'1','3',NULL,NULL,'1'),
        (71,8,'2','0',NULL,NULL,'1'),
        (72,8,'2','1',NULL,NULL,'2'),
        (73,8,'2','2',NULL,NULL,'4'),
        (74,8,'2','3',NULL,NULL,'8');
