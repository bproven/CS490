use dhg6;

drop table if exists cs490_StudentExamQuestionFeedback;
drop table if exists cs490_StudentExamTestCaseResult;
drop table if exists cs490_StudentExamTestCaseScore;
drop table if exists cs490_StudentExamQuestionScore;
drop table if exists cs490_StudentExamGrade;
drop table if exists cs490_StudentExamScore;
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
  hasIf    bool not null,
  hasWhile bool not null,
  hasFor   bool not null,
  hasRecursion bool not null
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
    values ( 1, 'CS 113 Exam', 'taj1' ),
           ( 2, 'CS 320 Exam', 'taj1' ),
           ( 3, 'CS 490 Exam', 'taj1' );

alter table cs490_Exam auto_increment = 4;

/* ExamQuestions */

create table cs490_ExamQuestion (
  examId     int not null,
  questionId int not null
);

insert into cs490_ExamQuestion 
    values  ( 1, 23 ),
            ( 1, 24 ),
            ( 1, 25 ),
            ( 2, 25 ),
            ( 2, 26 ),
            ( 3, 23 ),
            ( 3, 24 );

/* ExamQuestionAnswer */

create table cs490_ExamQuestionAnswer (
    ucid        varchar(8) not null,
    examId      int not null,
    questionId  int not null,
    answer      text
);

insert into cs490_ExamQuestionAnswer
    values  ( 'rap9', 1, 23, 'this is a sample answer 23' ),
            ( 'rap9', 1, 24, 'this is a sample answer 24' ),
            ( 'rap9', 1, 25, 'this is a sample answer 25' ),
            ( 'rap9', 2, 25, 'this is a sample answer 25' ),
            ( 'rap9', 2, 26, 'this is a sample answer 26' ),
            ( 'rap9', 3, 23, 'this is a sample answer 23' ),
            ( 'rap9', 3, 24, 'this is a sample answer 24' );

/* StudentExamGrades */

create table cs490_StudentExamScore (
  ucid   varchar(8) not null,
  examId int not null,
  score  int not null,
  possible int not null  
);

insert into cs490_StudentExamGrade
    values  ( 'dhg6', 1, 85, 100 ),
            ( 'rap9', 1, 55, 100 ),
            ( 'rap9', 2, 65, 100 ),
            ( 'rap9', 3, 75, 100 ),
            ( 'keg9', 1, 99, 100 );

/* StudentExamQuestionScore */

create table cs490_StudentExamQuestionScore (
    ucid        varchar(8),
    examId      int not null,
    questionId  int not null,
    score       int not null,
    possible    int not null
);

insert into cs490_StudentExamQuestionScore
    values  ( 'rap9', 1, 23,  76, 100 ),
            ( 'rap9', 1, 24,  78, 100 ),
            ( 'rap9', 1, 25,  78, 100 ),
            ( 'rap9', 2, 25,  78, 100 ),
            ( 'rap9', 2, 26,  78, 100 ),
            ( 'rap9', 3, 23,  78, 100 ),
            ( 'rap9', 3, 24,  78, 100 ),
            ( 'dhg6', 1, 25,  63, 100 ),
            ( 'dhg6', 1, 26,  65, 100 ),
            ( 'keg9', 1, 25, 100, 100 ),
            ( 'keg9', 1, 26,  98, 100 );

/* StudentExamQuestionFeedback */

create table cs490_StudentExamQuestionFeedback (
    feedbackId  int not null  auto_increment primary key,
    ucid        varchar(8) not null,
    examId      int not null,
    questionId  int not null,
    description varchar( 64 ) not null,
    correct     bool not null,
    score       int not null,
    possible    int not null
);

insert into cs490_StudentExamQuestionFeedback
    values  (  1, 'rap9', 1, 23, "feedback 1",  true, 1, 1 ),
            (  2, 'rap9', 1, 23, "feedback 2", false, 0, 1 ),
            (  3, 'rap9', 1, 24, "feedback 3",  true, 1, 1 ),
            (  4, 'rap9', 1, 24, "feedback 4", false, 0, 1 ),
            (  5, 'rap9', 1, 25, "feedback 5",  true, 1, 1 ),
            (  6, 'rap9', 1, 25, "feedback 6", false, 0, 1 ),

            (  7, 'rap9', 2, 25, "feedback 7",  true, 1, 1 ),
            (  8, 'rap9', 2, 25, "feedback 8", false, 0, 1 ),
            (  9, 'rap9', 2, 26, "feedback 9",  true, 1, 1 ),
            ( 10, 'rap9', 2, 26, "feedback 10", false, 0, 1 ),

            ( 11, 'rap9', 3, 23, "feedback 7",  true, 1, 1 ),
            ( 12, 'rap9', 3, 23, "feedback 8", false, 0, 1 ),
            ( 13, 'rap9', 3, 24, "feedback 9",  true, 1, 1 ),
            ( 14, 'rap9', 3, 24, "feedback 10", false, 0, 1 ),

            ( 15, 'dhg6', 1, 24, "feedback 3",  true, 1, 1 ),
            ( 16, 'dhg6', 1, 25, "feedback 4", false, 0, 1 ),
            ( 17, 'keg9', 1, 23, "feedback 5",  true, 1, 1 ),
            ( 18, 'keg9', 1, 25, "feedback 6", false, 0, 1 );

alter table cs490_StudentExamQuestionFeedback auto_increment = 19;
