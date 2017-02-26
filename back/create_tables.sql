use dhg6;

drop table if exists `cs490_ExamGrades`;

create table `cs490_ExamGrades` (
  `UCID`   text    not null,
  `ExamId` int(11) not null,
  `Grade`  int(11) not null
);

insert into `cs490_ExamGrades` 
    values ('dhg6',1,64);

drop table if exists `cs490_ExamQuestions`;

create table `cs490_ExamQuestions` (
  `ExamId`     int(11) not null,
  `QuestionId` int(11) not null,
  `Points`     int(11) not null
);

insert into `cs490_ExamQuestions` 
    values  (1,22,25),
            (1,23,25),
            (1,24,25),
            (1,25,25),
            (2,22,50),
            (2,25,50),
            (5,26,50),
            (5,22,20),
            (5,23,25),
            (5,24,5);

drop table if exists `cs490_Questions`;

create table `cs490_Questions` (
  `Id` int(11) not null auto_increment,
  `Question`  text,
  `Answer`    text,
  `Argument1` text,
  `Argument2` text,
  `Argument3` text,
  `Argument4` text,
  `Difficulty` text,
  `FunctionName` text,
  `HasIf`    bool,
  `HasWhile` bool,
  `HasFor`   bool,
  PRIMARY KEY (`Id`)
) auto_increment = 27;

insert into `cs490_Questions` 
    values  (22,'prints using \'println\' all numbers in sequence leading up to, and including it, using \'i\' to iterate through the for loop, and','public static void count(int x) {\r\n      for (int i=1; i<=x; i++){\r\n         System.out.println(i);}','x','','','','Medium','count',0,0,1),
            (23,'returns the sum of two integers','public static int sum(int x, int y) {\r\n      return (x+y); }','x',1,'','','Easy','sum',0,0,0),
            (24,'returns one integer subtracted by a second','   public static int minus(int x, int y) {\r\n      return (x-y); }','x',1,'','','Easy','minus',0,0,0),
            (25,'returns the remainder of one integer divided by another','public static int remainder(int x, int y) {\r\n      return (x%y);}','x',1,'','','Medium','remainder',0,0,0),
            (26,'returns the product of two numbers,','public static int times(int x, int y) { return (x*y); }','a','b','','','Medium','times',0,0,0);

drop table if exists `cs490_Users`;

create table `cs490_Users` (
  `UCID`     varchar(20) not null,
  `Password` varchar(20) not null,
  `First`    varchar(20) not null,
  `Last`     varchar(20) not null,
  `Privelege` char(1) not null
);

insert into `cs490_Users` 
    values  ('dhg6','password','Dan','Gordon','S'),
            ('rap9','password','Bob','Provencher','S'),
            ('keg9','password','Keith','Grubbs','S'),
            ('taj1','password','Tom','Jones','I'),
            ('jsp9','password','Jamie','Platt','S'),
            ('cod6','password','Cody','Doogan','S');
