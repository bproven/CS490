use dhg6;

/* Users */

drop table if exists cs490_User;

create table cs490_User (
  ucid      varchar(8) not null,
  password  varchar(20) not null,
  firstName varchar(20) not null,
  lastName  varchar(20) not null,
  privelege char(1) not null
);

insert into cs490_User 
    values  ('dhg6','password','Dan',   'Gordon',    'S'),
            ('rap9','password','Bob',   'Provencher','S'),
            ('keg9','password','Keith', 'Grubbs',    'S'),
            ('taj1','password','Tom',   'Jones',     'I'),
            ('jsp9','password','Jamie', 'Platt',     'S'),
            ('cod6','password','Cody',  'Doogan',    'S');

/* Questions */

drop table if exists cs490_Question;

create table cs490_Question (
  questionId int not null auto_increment primary key,
  question  text,
  argument1 varchar(8),
  argument2 varchar(8),
  argument3 varchar(8),
  argument4 varchar(8),
  returnType varchar(8),
  difficulty int,
  functionName varchar(64),
  hasIf    bool,
  hasWhile bool,
  hasFor   bool,
  hasRecursion bool
);

insert into cs490_Question 
    values  (23,'returns the sum of two integers',                          'int','int',null,null,'int',1,'sum',          false,false,false,false),
            (24,'returns one integer subtracted by a second',               'int','int',null,null,'int',1,'minus',        false,false,false,false),
            (25,'returns the remainder of one integer divided by another',  'int','int',null,null,'int',2,'remainder',    false,false,false,false),
            (26,'returns the product of two numbers,',                      'int','int',null,null,'int',1,'times',        false,false,false,false);

alter table cs490_Question auto_increment = 27;

/* Test Case */

drop table if exists cs490_TestCase;

create table cs490_TestCase (
    testCaseId    int not null auto_increment primary key,
    questionId    int not null,
    argument1     varchar(16),
    argument2     varchar(16),
    argument3     varchar(16),
    argument4     varchar(16),
    returnValue   varchar(16)
);

insert into cs490_TestCase
    values  ( 1, 23,  '2', '3', null, null,  '5' ),
            ( 2, 24,  '5', '3', null, null,  '2' ),
            ( 3, 25, '10', '3', null, null,  '1' ),
            ( 4, 26,  '5', '8', null, null, '40' );

alter table cs490_TestCase auto_increment = 5;

/* Exams */

drop table if exists cs490_Exam;

create table cs490_Exam (
    examId    int not null auto_increment primary key,
    examName  varchar(64) not null,
    ownerId   varchar(8) not null
);

insert into cs490_Exam 
    values ( 1, 'CS 490 Exam', 'taj1' );

alter table cs490_Exam auto_increment = 2;

/* ExamQuestions */

drop table if exists cs490_ExamQuestion;

create table cs490_ExamQuestion (
  examId     int not null,
  questionId int not null,
  points     int not null
);

insert into cs490_ExamQuestion 
    values  ( 1, 23, 25 ),
            ( 1, 24, 25 ),
            ( 1, 25, 25 ),
            ( 2, 25, 50 ),
            ( 5, 26, 50 ),
            ( 5, 23, 25 ),
            ( 5, 24,  5 );

/* ExamQuestionAnswer */

drop table if exists cs490_ExamQuestionAnswer;

create table cs490_ExamQuestionAnswer (
    ucid        varchar(8) not null,
    examId      int not null,
    questionId  int not null,
    answer      text
);

insert into cs490_ExamQuestionAnswer
    values  ( 'dhg6', 1, 26, 'this is a sample answer' );

/* ExamGrades */

drop table if exists cs490_ExamGrade;

create table cs490_ExamGrade (
  ucid   varchar(8) not null,
  examId int not null,
  grade  int not null
);

insert into cs490_ExamGrade
    values  ('dhg6',1,64),
            ('rap9',1,55),
            ('keg9',1,99);
