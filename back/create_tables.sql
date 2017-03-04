use dhg6;

drop table if exists cs490_StudentExamTestCaseScore;
drop table if exists cs490_StudentExamQuestionScore;
drop table if exists cs490_StudentExamGrade;
drop table if exists cs490_ExamGrade;
drop table if exists cs490_ExamGrades;
drop table if exists cs490_ExamQuestionAnswer;
drop table if exists cs490_ExamQuestionAnswers;
drop table if exists cs490_ExamQuestion;
drop table if exists cs490_ExamQuestions;
drop table if exists cs490_Exam;
drop table if exists cs490_Exams;
drop table if exists cs490_TestCase;
drop table if exists cs490_TestCases;
drop table if exists cs490_Question;
drop table if exists cs490_Questions;
drop table if exists cs490_User;
drop table if exists cs490_Users;

/* Users */

create table cs490_User (
  id        char(36)    not null primary key,
  ucid      varchar(8)  not null,
  password  char(32)    not null,
  firstName varchar(20) not null,
  lastName  varchar(20) not null,
  privelege char(1)     not null
);

insert into cs490_User 
    values  ( UUID(), 'dhg6',MD5('password'),'Dan',   'Gordon',    'S'),
            ( UUID(), 'rap9',MD5('password'),'Bob',   'Provencher','S'),
            ( UUID(), 'keg9',MD5('password'),'Keith', 'Grubbs',    'S'),
            ( UUID(), 'taj1',MD5('password'),'Tom',   'Jones',     'I'),
            ( UUID(), 'jsp9',MD5('password'),'Jamie', 'Platt',     'S'),
            ( UUID(), 'cod6',MD5('password'),'Cody',  'Doogan',    'S');

/* Questions */

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

create table cs490_Exam (
    examId    int not null auto_increment primary key,
    examName  varchar(64) not null,
    ownerId   varchar(8) not null
);

insert into cs490_Exam 
    values ( 1, 'CS 490 Exam', 'taj1' );

alter table cs490_Exam auto_increment = 2;

/* ExamQuestions */

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

create table cs490_ExamQuestionAnswer (
    ucid        varchar(8) not null,
    examId      int not null,
    questionId  int not null,
    answer      text
);

insert into cs490_ExamQuestionAnswer
    values  ( 'dhg6', 1, 26, 'this is a sample answer' );

/* StudentExamGrades */

create table cs490_StudentExamGrade (
  ucid   varchar(8) not null,
  examId int not null,
  grade  int not null
);

insert into cs490_StudentExamGrade
    values  ( 'dhg6', 1, 64 ),
            ( 'rap9', 1, 55 ),
            ( 'keg9', 1, 99 );

/* StudentExamQuestionScore */

create table cs490_StudentExamQuestionScore (
    ucid        varchar(8),
    examId      int not null,
    questionId  int not null,
    score       int not null
);

insert into cs490_StudentExamQuestionScore
    values  ( 'rap9', 1, 25, 76 ),
            ( 'rap9', 1, 26, 78 ),
            ( 'dhg6', 1, 25, 63 ),
            ( 'dhg6', 1, 26, 65 ),
            ( 'keg9', 1, 25, 100 ),
            ( 'keg9', 1, 26, 98 );

/* StudentExamTestCaseScore */

create table cs490_StudentExamTestCaseScore (
    ucid        varchar(8),
    examId      int not null,
    testCaseId  int not null,
    score       int not null
);

insert into cs490_StudentExamTestCaseScore
    values  ( 'rap9', 1, 3,  76 ),
            ( 'rap9', 1, 4,  78 ),
            ( 'dhg6', 1, 3,  63 ),
            ( 'dhg6', 1, 4,  65 ),
            ( 'keg9', 1, 3, 100 ),
            ( 'keg9', 1, 4,  98 );
