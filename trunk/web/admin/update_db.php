<?php require("admin-header.php");

if (!(isset($_SESSION[$OJ_NAME.'_'.'administrator']))){
	echo "<a href='../loginpage.php'>Please Login First!</a>";
	exit(1);
}?>
<?php $tsql=Array();
$csql=Array();
$tsql[0]="select 1 from topic limit 1";
$csql[0]="
CREATE TABLE `topic` (
  `tid` int(11) NOT NULL auto_increment,
  `title` varbinary(60) NOT NULL,
  `status` int(2) NOT NULL default '0',
  `top_level` int(2) NOT NULL default '0',
  `cid` int(11) default NULL,
  `pid` int(11) NOT NULL,
  `author_id` varchar(20) NOT NULL,
  PRIMARY KEY  (`tid`),
  KEY `cid` (`cid`,`pid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
$tsql[1]="select 1 from reply limit 1";
$csql[1]="
CREATE TABLE `reply` (
 `rid` int(11) NOT NULL auto_increment,
 `author_id` varchar(20) NOT NULL,
 `time` datetime NOT NULL default '2000-01-01 00:00:01',
 `content` text NOT NULL,
 `topic_id` int(11) NOT NULL,
 `status` int(2) NOT NULL default '0',
 `ip` varchar(30) NOT NULL,
 PRIMARY KEY  (`rid`),
 KEY `author_id` (`author_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
";
$tsql[2]="
ALTER TABLE `problem` DROP COLUMN `sample_Program`,
 DROP COLUMN `ratio`,
 DROP COLUMN `error`,
 DROP COLUMN `difficulty`,
 DROP COLUMN `submit_user`,
 DROP COLUMN `case_time_limit`;
 ";
$csql[2]="";
$tsql[3]="select 1 from sim limit 1";
$csql[3]="
CREATE TABLE `sim` (
  `s_id` int(11) NOT NULL,
  `sim_s_id` int(11) NULL,
  `sim` int(11) NULL,
  PRIMARY KEY  (`s_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$tsql[4]="select 1 from mail limit 1";
$csql[4]="
CREATE TABLE `mail` (

  `mail_id` int(11) NOT NULL auto_increment,
  `to_user` varchar(20) NOT NULL default '',
  `from_user` varchar(20) NOT NULL default '',
  `title` varchar(200) NOT NULL default '',
  `content` text,
  `new_mail` tinyint(1) NOT NULL default '1',
  `reply` tinyint(4) default '0',
  `in_date` datetime default NULL,
  `defunct` char(1) NOT NULL default 'N',
  PRIMARY KEY  (`mail_id`),
  KEY `uid` (`to_user`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1000 ;";   
 
$tsql[5]="ALTER TABLE `solution` MODIFY COLUMN `pass_rate` DECIMAL(3,2) UNSIGNED NOT NULL DEFAULT 0,MODIFY COLUMN in_date datetime not null default '2009-06-13 19:00:00', MODIFY COLUMN `user_id` CHAR(48)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,MODIFY COLUMN `ip` CHAR(15)  CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;";
$csql[5]="";

$tsql[6]="select langmask from contest limit 1;";
$csql[6]="ALTER TABLE `contest` ADD COLUMN `langmask` TINYINT  NOT NULL DEFAULT 0 COMMENT 'bits for LANG to mask' AFTER `private`;";

$csql[7]="";
$tsql[7]="optimize table `compileinfo`,`contest` ,`contest_problem` ,`loginlog`,`news`,`privilege`,`problem` ,`solution`,`source_code`,`users`,`topic`,`reply`,`online`,`sim`,`mail`;";

$csql[8]="";
$tsql[8]="ALTER TABLE `contest` MODIFY COLUMN `langmask` INT UNSIGNED NOT NULL DEFAULT 0 COMMENT 'bits for LANG to mask';";
$tsql[9]="select 1 from runtimeinfo limit 1";
$csql[9]="CREATE TABLE  `runtimeinfo` (
  `solution_id` int(11) NOT NULL DEFAULT '0',
  `error` text,
  PRIMARY KEY (`solution_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
";
$tsql[10]="select pass_rate from solution limit 1";
$csql[10]="ALTER TABLE `solution` ADD COLUMN `pass_rate` DECIMAL(3,2) UNSIGNED NOT NULL DEFAULT 0 AFTER `judgetime`;";

$csql[11]="";
$tsql[11]="ALTER TABLE `users` MODIFY COLUMN `user_id` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";

$csql[12]="";
$tsql[12]="ALTER TABLE `topic` MODIFY COLUMN `author_id` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";

$csql[13]="";
$tsql[13]="ALTER TABLE `mail` MODIFY COLUMN `to_user` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id',MODIFY COLUMN `from_user` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";

$csql[14]="";
$tsql[14]="ALTER TABLE `reply` MODIFY COLUMN `author_id` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";

$csql[15]="";
$tsql[15]="ALTER TABLE `privilege` MODIFY COLUMN `user_id` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";

$csql[15]="";
$tsql[15]="ALTER TABLE `loginlog` MODIFY COLUMN `user_id` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";

$csql[15]="";
$tsql[15]="ALTER TABLE `news` MODIFY COLUMN `user_id` varchar(48) NOT NULL DEFAULT ''  COMMENT 'user_id';";
$tsql[16]="ALTER TABLE `sim` ADD INDEX `Index_sim_id`(`sim_s_id`);";
$csql[16]="";
$tsql[17]="ALTER TABLE `contest_problem` ADD INDEX `Index_contest_id`(`contest_id`);";
$csql[17]="";
$tsql[18]="ALTER TABLE `contest_problem` ADD INDEX `Index_problem_id`(`problem_id`);";
$csql[18]="";

$tsql[18]="select 1 from custominput limit 1;";
$csql[18]="CREATE TABLE  `custominput` (  `solution_id` int(11) NOT NULL DEFAULT '0',  `input_text` text,  PRIMARY KEY (`solution_id`)) ENGINE=MyISAM DEFAULT CHARSET=utf8;";

$tsql[19]="ALTER TABLE `loginlog` ADD INDEX `user_time_index`(`user_id`, `time`);";
$csql[19]="";
$tsql[20]="ALTER TABLE `contest` ADD `password` CHAR( 16 ) NOT NULL DEFAULT '' AFTER `langmask` ";
$csql[20]="";
$tsql[21]="create TABLE `source_code_user` like source_code";
$csql[21]="";

$tsql[22]="insert into source_code_user select * from source_code where solution_id not in (select solution_id from source_code_user)  ";
$csql[22]="";

$tsql[23]="select judger from solution limit 1 ";
$csql[23]="ALTER TABLE `solution` ADD `judger` CHAR(16) NOT NULL DEFAULT 'LOCAL' ;  ";

$tsql[24]="alter table solution modify column pass_rate decimal(3,2) NOT NULL DEFAULT 0;";
$csql[24]="";

$csql[25]="";
$tsql[25]="ALTER TABLE  `solution` CHANGE  `ip`  `ip` CHAR( 46 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '';";
$csql[26]="select 1 from printer limit 1";
$tsql[26]="CREATE TABLE  `printer` (
  `printer_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` char(48) NOT NULL,
  `in_date` datetime NOT NULL DEFAULT '2018-03-13 19:38:00',
  `status` smallint(6) NOT NULL DEFAULT '0',
  `worktime` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `printer` CHAR(16) NOT NULL DEFAULT 'LOCAL',
  `content` text NOT NULL ,
  PRIMARY KEY (`printer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
$csql[27]="select 1 from balloon limit 1";
$tsql[27]="CREATE TABLE  `balloon` (
  `balloon_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` char(48) NOT NULL,
  `sid` int(11) NOT NULL ,
  `cid` int(11) NOT NULL ,
  `pid` int(11) NOT NULL ,
  `status` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`balloon_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;";
$csql[28]="select 1 from share_code limit 1";
$tsql[28]="create TABLE `share_code` (
  `share_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` varchar(48) COLLATE utf8_unicode_ci DEFAULT NULL,
  `title` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `share_code` text COLLATE utf8_unicode_ci,
  `language` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `share_time` datetime DEFAULT NULL,
  PRIMARY KEY (`share_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;";
$tsql[29]="alter TABLE `contest` ADD `user_id` CHAR( 48 ) NOT NULL DEFAULT 'admin' AFTER `password` ";
$csql[29]="update contest c inner JOIN (SELECT * FROM privilege WHERE rightstr LIKE 'm%') p ON concat('m',contest_id)=rightstr set c.user_id=p.user_id";
$tsql[30]="alter TABLE  `contest_problem` ADD  `c_accepted` INT NOT NULL DEFAULT  '0' AFTER  `num` ,ADD  `c_submit` INT NOT NULL DEFAULT  '0' AFTER  `c_accepted`";
$csql[30]="";
$tsql[31]="update contest_problem cp inner join (select count(1) submit,contest_id cid,num from solution where contest_id>0 group by contest_id,num) sb on cp.contest_id=sb.cid and cp.num=sb.num set cp.c_submit=sb.submit";
$csql[31]="update contest_problem cp inner join (select count(1) ac,contest_id cid,num from solution where contest_id>0 and result=4 group by contest_id,num) sb on cp.contest_id=sb.cid and cp.num=sb.num set cp.c_accepted=sb.ac";
$tsql[32]="alter table solution add column nick char(20) not null default '' after user_id ";
$csql[32]="update solution s inner join users u on s.user_id=u.user_id set s.nick=u.nick";
$tsql[33]="update problem p inner join (select problem_id pid ,count(1) submit from solution group by problem_id) s on p.problem_id=s.pid set p.submit=s.submit;";
$csql[33]="";
$tsql[34]="alter table privilege add index user_id_index(user_id);";
$csql[34]="";
$tsql[35]="ALTER TABLE `problem` CHANGE `time_limit` `time_limit` DECIMAL(10,3) NOT NULL DEFAULT '0';";
$csql[35]="";
$tsql[36]="alter table privilege add column valuestr char(11) not null default 'true' after rightstr; ";
$csql[36]="";

$tsql[37]="ALTER TABLE `news` ADD COLUMN `menu` int(11) NOT NULL DEFAULT 0 AFTER `importance`; ";
$csql[37]="";
if(isset($_POST['do'])){
	require_once("../include/check_post_key.php");
	echo "Executing...<br>";
	for($i=0;isset($tsql[$i]);$i++){
    echo "<br><br>";
		if(pdo_query($tsql[$i])){
				echo $csql[$i]."<br>";
				pdo_query($csql[$i], true);
		}else{
				echo $tsql[$i]."<br>";
		}
		
	}
}
?>
<div class="container">
<b>Update DataBase</b>
	Create New Tables ,drop useless columes.
	<b>Necessary for using plagiarism detection.</b>
	<form action='update_db.php' method=post>
		<?php require_once("../include/set_post_key.php");?>
		<input type='hidden' name='do' value='do'>
		<input type=submit value=Update>
	</form>
	
<?php if (file_exists("update_pw.php")) {	?>
   <a href="update_pw.php">Upgrade all users password storage form to get more security.</a>
   * only do once !
<?php }?>
</div>
