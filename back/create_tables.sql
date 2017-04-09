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

/* Exams */

create table cs490_Exam (
    examId    int not null auto_increment primary key,
    examName  varchar(64) not null,
    ownerId   varchar(8) not null
);

/* ExamQuestions */

create table cs490_ExamQuestion (
  examId     int not null,
  questionId int not null
);

/* ExamQuestionAnswer */

create table cs490_ExamQuestionAnswer (
    ucid        varchar(8) not null,
    examId      int not null,
    questionId  int not null,
    answer      text
);

/* StudentExamGrades */

create table cs490_StudentExamScore (
  ucid   varchar(8) not null,
  examId int not null,
  score  int not null,
  possible int not null  
);

/* StudentExamQuestionScore */

create table cs490_StudentExamQuestionScore (
    ucid        varchar(8),
    examId      int not null,
    questionId  int not null,
    score       int not null,
    possible    int not null
);

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

