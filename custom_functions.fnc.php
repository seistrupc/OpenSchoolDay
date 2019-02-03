<?php
#**************************************************************************
#  openSIS is a free student information system for public and non-public 
#  schools from Open Solutions for Education, Inc. web: www.os4ed.com
#
#  openSIS is  web-based, open source, and comes packed with features that 
#  include student demographic info, scheduling, grade book, attendance, 
#  report cards, eligibility, transcripts, parent portal, 
#  student portal and more.   
#
#  Visit the openSIS web site at http://www.opensis.com to learn more.
#  If you have question regarding this system or the license, please send 
#  an email to info@os4ed.com.
#
#  This program is released under the terms of the GNU General Public License as  
#  published by the Free Software Foundation, version 2 of the License. 
#  See license.txt.
#
#  This program is distributed in the hope that it will be useful,
#  but WITHOUT ANY WARRANTY; without even the implied warranty of
#  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
#  GNU General Public License for more details.
#
#  You should have received a copy of the GNU General Public License
#  along with this program.  If not, see <http://www.gnu.org/licenses/>.
#
#***************************************************************************************
function TextAreaInputOrg($value,$name,$title='',$options='',$div=true, $divwidth='500px')
{
	if(Preferences('HIDDEN')!='Y')
		$div = false;

	if(AllowEdit() && !$_REQUEST['_openSIS_PDF'])
	{
		$value = str_replace("'",'&#39;',str_replace('"','&rdquo;',$value));

		if(strpos($options,'cols')===false)
			$options .= ' cols=30';
		if(strpos($options,'rows')===false)
			$options .= ' rows=4';
		$rows = substr($options,strpos($options,'rows')+5,2)*1;
		$cols = substr($options,strpos($options,'cols')+5,2)*1;

		if($value=='' || $div==false)
			return "<TEXTAREA name=$name $options>$value</TEXTAREA>".($title!=''?'<BR><small>'.(strpos(strtolower($title),'<font ')===false?'<FONT color='.Preferences('TITLES').'>':'').$title.(strpos(strtolower($title),'<font ')===false?'</FONT>':'').'</small>':'');
		else
			return "<DIV id='div$name'><div style='width:500px;' onclick='javascript:addHTML(\"<TEXTAREA id=textarea$name name=$name $options>".ereg_replace("[\n\r]",'\u000D\u000A',str_replace("\r\n",'\u000D\u000A',str_replace("'","&#39;",$value)))."</TEXTAREA>".($title!=''?"<BR><small>".str_replace("'",'&#39;',(strpos(strtolower($title),'<font ')===false?'<FONT color='.Preferences('TITLES').'>':'').$title.(strpos(strtolower($title),'<font ')===false?'</FONT>':''))."</small>":'')."\",\"div$name\",true); document.getElementById(\"textarea$name\").value=unescape(document.getElementById(\"textarea$name\").value);'><TABLE class=LO_field height=100%><TR><TD>".((substr_count($value,"\r\n")>$rows)?'<DIV style="overflow:auto; height:'.(15*$rows).'px; width:'.($cols*10).'; padding-right: 16px;">'.nl2br($value).'</DIV>':'<DIV style="overflow:auto; width:'.$divwidth.'; padding-right: 16px;">'.nl2br($value).'</DIV>').'</TD></TR></TABLE>'.($title!=''?'<BR><small>'.str_replace("'",'&#39;',(strpos(strtolower($title),'<font ')===false?'<FONT color='.Preferences('TITLES').'>':'').$title.(strpos(strtolower($title),'<font ')===false?'</FONT>':'')).'</small>':'').'</div></DIV>';
	}
	else
		return (($value!='')?nl2br($value):'-').($title!=''?'<BR><small>'.(strpos(strtolower($title),'<font ')===false?'<FONT color='.Preferences('TITLES').'>':'').$title.(strpos(strtolower($title),'<font ')===false?'</FONT>':'').'</small>':'');
}

function ShowErr($msg)
{
	echo "<script type='text/javascript'>
	document.getElementById('divErr').innerHTML='<font color=red>".$msg."</font>';</script>";
}
function ShowErrPhp($msg)
{
	echo '<font color=red>'.$msg.'<br /></font>';
}
function for_error()
{
 		$css=getCSS(); 		
		echo "<br><br><form action=Modules.php?modname=$_REQUEST[modname] method=post>";
		echo '<BR><CENTER>'.SubmitButton(''._('Try Again').'','','class=btn_medium').'</CENTER>';
		echo "</form>";	
		echo "</div>";

	echo "</td>
                                        </tr>
                                      </table></td>
                                  </tr>
                                </table></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>

			<tr>
            <td class=\"footer\">
			<table width=\"100%\" border=\"0\">
  <tr>
    <td align='center' class='copyright'>
       <center>"._('openSIS is a product of Open Solutions for Education, Inc.')." (<a href='http://www.os4ed.com' target='_blank'>"._('OS4Ed')."</a>).
                "._('and is licensed under the')." <a href='http://www.gnu.org/licenses/gpl.html' target='_blank'>"._('GPL License')."</a>.
                </center></td>
  </tr>
</table>
			</td>
          	</tr>
        </table></td>
    </tr>
  </table>
</center>
</body>
</html>";

		exit();
}



function ExportLink($modname,$title='',$options='')
{
	if(AllowUse($modname))
		$link = '<A HREF=for_export.php?modname='.$modname.$options.'>';
	if($title)
		$link .= $title;
	if(AllowUse($modname))
		$link .= '</A>';

	return $link;
}

function getCSS()
{
		$css='Blue';
		if(User('STAFF_ID'))
		{
		$sql = 'select value from program_user_config where title=\'THEME\' and user_id='.User('STAFF_ID');
		$data = DBGet(DBQuery($sql));
		if(count($data[1]))
		$css=$data[1]['VALUE']; 
		}
		return $css;		
}


function Prompt_Calender($title='Confirm',$question='',$message='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		echo '<BR>';
		PopTable('header',''._($title).'');
		echo "<CENTER><h4>$question</h4><FORM name=prompt_form id=prompt_form action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value="._('OK')." onclick='formcheck_school_setup_calender();'>&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value="._('Cancel')." onclick='load_link(\"Modules.php?modname=$_REQUEST[modname]\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}


function Prompt_Copy_School($title='Confirm',$question='',$message='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		echo '<BR>';
		PopTable('header',''._($title).'');
		echo "<CENTER><h4>$question</h4><FORM name=prompt_form id=prompt_form action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value="._('OK')." onclick='formcheck_school_setup_copyschool();'>&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value="._('Cancel')." onclick='load_link(\"Modules.php?modname=School_Setup/Calendar.php\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}


function Prompt_rollover($title='Confirm',$question='',$message='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		
		PopTable('header',''._($title).'');
	//	echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value=OK onclick=\"document.roll_over.submit();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='javascript:history.go(-1);'></FORM></CENTER>";
        echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>";
		echo '<BR><font color=red>'._('Caution').' : </font>'._('Rollover is an irreversible process.  If you are sure you want to proceed, type in the.').' <BR>'._('effective  roll over date below. You can use the next school year’s attendance start date.').'<BR><BR>';
		echo '<table><tr><td>'._('Student Enrollment Date').':</td><td>';
		echo DateInput('','roll_start_date','');
                echo '<td></tr>';
                echo '<tr><td>';
//                echo '<input type=checkbox id=custom_date name=custom_date value=Y onClick="show_date_picker();" >';
                echo '<input type=hidden id=custom_date name=custom_date value=Y></td></tr>';
//                echo 'Input Custom Start Date And End Date</td></tr>';
                echo '</table>';
                echo '<input type=hidden id=check_click value=1>';
//                echo '<div id=show_date_range style="display:none">';
                echo '<hr>';
                echo '<b>'._('Enter next school year’s begin and end dates.').'</b>';
                echo '<br>';
                echo '<table></td></tr><td>'._('School Begin Date').' :</td>';
                echo '<td>'.DateInput('','roll_school_start_date','').'</td>';
                echo '<tr><td>'._('School End Date').' :</td><td>'.DateInput('','roll_school_end_date','').'</td></tr></table>';
                echo '<hr>';
                $prev_st_d=DBGet(DBQuery('SELECT END_DATE FROM school_years WHERE SYEAR=\''.UserSyear().'\' AND SCHOOL_ID=\''.UserSchool().'\' '));
                echo '<input type=hidden id=prev_start_date value='.$prev_st_d[1]['END_DATE'].' >';
                    $check_ss=DBGet(DBQuery('SELECT * FROM school_semesters WHERE SYEAR=\''.UserSyear().'\' AND SCHOOL_ID=\''.UserSchool().'\' ORDER BY MARKING_PERIOD_ID'));
                    if(count($check_ss)>0)
                    {
                    $i=4;
                    $j=4;
                    $t=0;
                    $q=0;
                    $p=0;
                    $sem=0;
                    $qrtr=0;
                    $prog=0;
                    foreach($check_ss as $ss_i=>$ss_d)
                    {
                      $sem++;
                       echo '<table></td></tr><td>'.$ss_d['TITLE'].' '._('Begin Date').' :</td>';    
                       echo '<td>'.DateInput('','sem_start_'.$sem,'');
                       echo '<input type=hidden id=name_'.$j.' value="'.$ss_d['TITLE'].' '._('Begin Date').'" ></td>';
                       $j++;
                       echo '<tr><td>'.$ss_d['TITLE'].' '._('End Date').' :</td><td>'.DateInput('','sem_end_'.$sem,'');   
                       echo '<input type=hidden id=name_'.$j.' value="'.$ss_d['TITLE'].' '._('End Date').'" ></td></tr></table>';
                       
                       $check_sq=DBGet(DBQuery('SELECT * FROM school_quarters WHERE SYEAR=\''.UserSyear().'\' AND SCHOOL_ID=\''.UserSchool().'\' AND SEMESTER_ID=\''.$ss_d['MARKING_PERIOD_ID'].'\' '));
                       if(count($check_sq)>0)
                        {   
                           $q=$j+1;
                           $q_val='';
                           $p_val='';
                            foreach($check_sq as $sq_i=>$sq_d)
                            { $qrtr++;
                               echo '<table></td></tr><td>'.$sq_d['TITLE'].' '._('Begin Date').' :</td>';    
                               echo '<td>'.DateInput('','qrtr_start_'.$qrtr,'');
                               echo '<input type=hidden id=name_'.$q.' value="'.$sq_d['TITLE'].' '._('Begin Date').'" ></td>';
                               $q_val.=$q.'`';
                               $q++;
                               $q_val.=$q.'-';
                               echo '<tr><td>'.$sq_d['TITLE'].' '._('End Date').' :</td><td>'.DateInput('','qrtr_end_'.$qrtr,'');   
                               echo '<input type=hidden id=name_'.$q.' value="'.$sq_d['TITLE'].' '._('End Date').'" ></td></tr></table>';
//                            echo '<input type=text name=qrt_count id=qrt_count value='.$i.'>';
                            $check_sp=DBGet(DBQuery('SELECT * FROM school_progress_periods WHERE SYEAR=\''.UserSyear().'\' AND SCHOOL_ID=\''.UserSchool().'\' AND QUARTER_ID=\''.$sq_d['MARKING_PERIOD_ID'].'\'   '));
                            if(count($check_sp)>0)
                            {
                                
                                $p=$q+1;
                                $max=count($check_sp);
                                foreach($check_sp as $sp_i=>$sp_d)
                                {$prog++;
                                   echo '<table></td></tr><td>'.$sp_d['TITLE'].' '._('Begin Date').' :</td>';    
                                   echo '<td>'.DateInput('','prog_start_'.$prog,'');
                                   echo '<input type=hidden id=name_'.$p.' value="'.$sp_d['TITLE'].' '._('Begin Date').'" ></td>';
                                   $p_val.=$p.'`';
                                   $p++;
                                   if($sp_i!=$max)
                                   {    
                                   $p_val.=$p.'^';
                                   }
                                   else
                                   $p_val.=$p.'-';
                                   echo '<tr><td>'.$sp_d['TITLE'].' '._('End Date').' :</td><td>'.DateInput('','prog_end_'.$prog,'');   
                                   echo '<input type=hidden id=name_'.$p.' value="'.$sp_d['TITLE'].' '._('End Date').'" ></td></tr></table>';
                                   $p++;
                                }
//                                echo '<input type=text name=prg_count id=prg_count value='.$i.'>';
                            }
                            if($p!=0)
                            $q=$p;
                            else
                            $q++;
                            }
                        }
                        $t++;
                        echo '<input type=hidden id=round_'.$t.' value='.$j.'>'; 
                        $q_val=substr($q_val,0,-1);
                        echo '<input type=hidden id=quarter_'.$t.' value='.$q_val.'>'; 
                        $p_val=substr($p_val,0,-1);
                        echo '<input type=hidden id=progress_'.$t.' value='.$p_val.'>'; 
                        echo '<hr>';
                        if($q!=0)
                        $j=$q;
                        else
                        $j++;
                        echo '<input type=hidden id=roll_'.$t.' value='.$j.'>';
                        
                        
                    }
                        echo '<input type=hidden name=tot_round id=tot_round value='.$t.'>';
                        echo '<input type=hidden name=total_sem value='.$sem.'>';
                        echo '<input type=hidden name=total_qrt value='.$qrtr.'>';
                        echo '<input type=hidden name=total_prg value='.$prog.'>';

                    }
//                    echo '</div>';
                echo '<BR>'._('The following items will be rolled over to the next school year.  Uncheck the item(s)').' <br/>'._('you do not want to be rolled over. Some items are mandatory and cannot be').' <br/>'._('unchecked.').'<BR>';
		echo $message.'<BR>';
		//echo 'hi';
                echo "<BR><BR><INPUT type=submit class=btn_medium value="._('Rollover')." onclick=\"return formcheck_rollover();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value="._('Cancel')." onclick='load_link(\"Modules.php?modname=Tools/LogDetails.php\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}

function Prompt_rollover_back($title='Rollover',$question='',$pdf='')
{
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;

	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		echo '<BR>';
		PopTable('header',''._($title).'');
	//	echo "<CENTER><h4>$question</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>$message<BR><BR><INPUT type=submit class=btn_medium value=OK onclick=\"document.roll_over.submit();\">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value=Cancel onclick='javascript:history.go(-1);'></FORM></CENTER>";
                echo "<CENTER><h4>"._($question)."</h4><FORM name=roll_over id=roll_over action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST><BR>&nbsp;<INPUT type=submit class=btn_medium name=delete_cancel value="._('Ok')." onclick='load_link(\"Modules.php?modname=Tools/LogDetails.php\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;
}




function Prompt_Runschedule($title='Confirm',$question='',$message='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		echo '<BR>';
		PopTable('header',''._($title).'');
		echo "<CENTER><h4>"._($question)."</h4><FORM action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>"._($message)."<BR><BR><INPUT type=submit class=btn_medium value="._('OK').">&nbsp;<INPUT type=button class=btn_medium name=delete_cancel value="._('Cancel')." onclick='load_link(\"Modules.php?modname=Scheduling/Schedule.php\");'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}



#############################################################################################
# This function is written for the date reset problem, so if any date  resets to Jan 1 20 use this 

// SEND PrepareDateSchedule a name prefix, and a date in oracle format 'd-M-y' as the selected date to have returned a date selection series
// of pull-down menus
// For the default to be Not Specified, send a date of 00-000-00 -- For today's date, send nothing
// The date pull-downs will create three variables, monthtitle, daytitle, yeartitle
// The third parameter (booleen) specifies whether Not Specified should be allowed as an option

function PrepareDateSchedule($date='',$title='',$allow_na=true,$options='')
{	global $_openSIS;

	if($options=='')
		$options = array();
	if(!$options['Y'] && !$options['M'] && !$options['D'] && !$options['C'])
		$options += array('Y'=>true,'M'=>true,'D'=>true,'C'=>true);
		
	if($options['short']==true)
		$extraM = "style='width:60;' ";
	if($options['submit']==true)
	{
		$tmp_REQUEST['M'] = $tmp_REQUEST['D'] = $tmp_REQUEST['Y'] = $_REQUEST;
		unset($tmp_REQUEST['M']['month'.$title]);
		unset($tmp_REQUEST['D']['day'.$title]);
		unset($tmp_REQUEST['Y']['year'.$title]);
		$extraM .= "onchange='document.location.href=\"".PreparePHP_SELF($tmp_REQUEST['M'])."&amp;month$title=\"+this.form.month$title.value;'";
		$extraD .= "onchange='document.location.href=\"".PreparePHP_SELF($tmp_REQUEST['D'])."&amp;day$title=\"+this.form.day$title.value;'";
		$extraY .= "onchange='document.location.href=\"".PreparePHP_SELF($tmp_REQUEST['Y'])."&amp;year$title=\"+this.form.year$title.value;'";
	}
	
	if($options['C'])
		$_openSIS['PrepareDate']++;

	if(strlen($date)==9) // ORACLE
	{
		$day = substr($date,0,2);
		$month = substr($date,3,3);
		$year = substr($date,7,2);

		$return .= '<!-- '.$year.MonthNWSwitch($month,'tonum').$day.' -->';
	}
	else // POSTGRES
	{
		$temp = split('-',$date);
		if(strlen($temp[0])==4)
		{
			$day = $temp[2];
			$year = substr($temp[0],2,2);
		}
		else
		{
			$day = $temp[0];
			$year = substr($temp[2],2,2);
		}
		$month = MonthNWSwitch($temp[1],'tochar');

		$return .= '<!-- '.$year.MonthNWSwitch($month,'tonum').$day.' -->';
	}

	// MONTH  ---------------
	if($options['M'])
	{
		$return .= "<div style='float:left; margin-right:2px;'><SELECT CLASS=cal_month NAME=month".$title." id=monthSelect".$_openSIS['PrepareDate']." SIZE=1 $extraM>";
		//  -------------------------------------------------------------------------- //
		
		if($month == 'JAN')
			$month = 1;
		elseif($month == 'FEB')
			$month = 2;
		elseif($month == 'MAR')
			$month = 3;
		elseif($month == 'APR')
			$month = 4;
		elseif($month == 'MAY')
			$month = 5;
		elseif($month == 'JUN')
			$month = 6;
		elseif($month == 'JUL')
			$month = 7;
		elseif($month == 'AUG')
			$month = 8;
		elseif($month == 'SEP')
			$month = 9;
		elseif($month == 'OCT')
			$month = 10;
		elseif($month == 'NOV')
			$month = 11;
		elseif($month == 'DEC')
			$month = 12;
		
		//  -------------------------------------------------------------------------- //
		if($allow_na)
		{
			if($month=='000')
				$return .= "<OPTION value=\"\" SELECTED>N/A";else $return .= "<OPTION value=\"\">N/A";
		}
		
		if($month=='1'){$return .= "<OPTION VALUE=JAN SELECTED>"._('January')."";}else{$return .= "<OPTION VALUE=JAN>"._('January')."";}
		if($month=='2'){$return .= "<OPTION VALUE=FEB SELECTED>"._('February')."";}else{$return .= "<OPTION VALUE=FEB>"._('February')."";}
		if($month=='3'){$return .= "<OPTION VALUE=MAR SELECTED>"._('March')."";}else{$return .= "<OPTION VALUE=MAR>"._('March')."";}
		if($month=='4'){$return .= "<OPTION VALUE=APR SELECTED>"._('April')."";}else{$return .= "<OPTION VALUE=APR>"._('April')."";}
		if($month=='5'){$return .= "<OPTION VALUE=MAY SELECTED>"._('May')."";}else{$return .= "<OPTION VALUE=MAY>"._('May')."";}
		if($month=='6'){$return .= "<OPTION VALUE=JUN SELECTED>"._('June')."";}else{$return .= "<OPTION VALUE=JUN>"._('June')."";}
		if($month=='7'){$return .= "<OPTION VALUE=JUL SELECTED>"._('July')."";}else{$return .= "<OPTION VALUE=JUL>"._('July')."";}
		if($month=='8'){$return .= "<OPTION VALUE=AUG SELECTED>"._('August')."";}else{$return .= "<OPTION VALUE=AUG>"._('August')."";}
		if($month=='9'){$return .= "<OPTION VALUE=SEP SELECTED>"._('September')."";}else{$return .= "<OPTION VALUE=SEP>"._('September')."";}
		if($month=='10'){$return .= "<OPTION VALUE=OCT SELECTED>"._('October')."";}else{$return .= "<OPTION VALUE=OCT>"._('October')."";}
		if($month=='11'){$return .= "<OPTION VALUE=NOV SELECTED>"._('November')."";}else{$return .= "<OPTION VALUE=NOV>"._('November')."";}
		if($month=='12'){$return .= "<OPTION VALUE=DEC SELECTED>"._('December')."";}else{$return .= "<OPTION VALUE=DEC>"._('December')."";}
		
		$return .= "</SELECT></div>";
	}

	// DAY  ---------------
	if($options['D'])
	{
		$return .="<div style='float:left; margin-right:2px;'><SELECT NAME=day".$title." id=daySelect".$_openSIS['PrepareDate']." SIZE=1 $extraD>";
		if($allow_na)
		{
			if($day=='00'){$return .= "<OPTION value=\"\" SELECTED>N/A";}else{$return .= "<OPTION value=\"\">N/A";}
		}
		
		for($i=1;$i<=31;$i++)
		{
			if(strlen($i)==1)
				$print='0'.$i;
			else
				$print = $i;
			
			$return .="<OPTION VALUE=".$print;
			if($day==$print)
				$return .=" SELECTED";
			$return .=">$i ";
		}
		$return .="</SELECT></div>";
	}
	
	// YEAR	 ---------------
	if($options['Y'])
	{
		if(!$year)
		{
			$begin = date('Y') - 20;
			$end = date('Y') + 5;
		}
		else
		{
			if($year<50)
				$year = '20'.$year;
			else
				$year = '19'.$year;
			$begin = $year - 5;
			$end = $year + 5;
		}
	
		$return .="<div style='float:left; margin-right:2px;'><SELECT NAME=year".$title." id=yearSelect".$_openSIS['PrepareDate']." SIZE=1 $extraY>";
		if($allow_na)
		{
			if($year=='00'){$return .= "<OPTION value=\"\" SELECTED>N/A";}else{$return .= "<OPTION value=\"\">N/A";}
		}
			
		for($i=$begin;$i<=$end;$i++)
		{
			$return .="<OPTION VALUE=".substr($i,0);
			if($year==$i){$return .=" SELECTED";}
			$return .=">".$i;
		}
		$return .="</SELECT></div>";
	}
	
	if($options['C'])
		$return .= '<div style="margin-top:-3px; float:left"><img src="assets/calendar.gif" id="trigger'.$_openSIS['PrepareDate'].'" style="cursor: hand;" onmouseover=this.style.background=""; onmouseout=this.style.background=""; onClick='."MakeDate('".$_openSIS['PrepareDate']."',this);".' /></div>';
	
	if($_REQUEST['_openSIS_PDF'])
		$return = ProperDate($date);
	return $return;
}
#############################################################################################
function PromptCourseWarning($title='Confirm',$question='',$message='',$pdf='')
{	
	$tmp_REQUEST = $_REQUEST;
	unset($tmp_REQUEST['delete_ok']);
	if($pdf==true)
		$tmp_REQUEST['_openSIS_PDF'] = true;
		
	$PHP_tmp_SELF = PreparePHP_SELF($tmp_REQUEST);

	if(!$_REQUEST['delete_ok'] &&!$_REQUEST['delete_cancel'])
	{
		echo '<BR>';
		PopTable('header',''._($title).'');
		echo "<CENTER><h4>"._($question)."</h4><FORM action=$PHP_tmp_SELF&delete_ok=1 METHOD=POST>"._($message)."<BR><BR><INPUT type=button class=btn_medium name=delete_cancel value="._('Cancel')." onclick='javascript:history.go(-1);'></FORM></CENTER>";
		PopTable('footer');
		return false;
	}
	else
		return true;	
}


# ---------------------- Solution for screen error in Group scheduling start ---------------------------------------- #

function for_error_sch()
{
 		$css=getCSS(); 		
		echo "<br><br><form action=Modules.php?modname=$_REQUEST[modname] method=post>";
		echo '<BR><CENTER>'.SubmitButton(''._('Try Again').'','','class=btn_medium').'</CENTER>';
		echo "</form>";	
		echo "</div>";

	echo "</td>
                                        </tr>
                                      </table></td>
                                  </tr>
                                </table></td>
                            </tr>
                          </table></td>
                      </tr>
                    </table></td>
                </tr>
              </table></td>
          </tr>

        </table></td>
    </tr>
  </table>
</center>
</body>
</html>";

		exit();
}

# ------------------------------ Solution for screen error in Group scheduling end------------------------------------- #

################################### Select input with Disable Onlcik edit feature ##############

function SelectInput_Disonclick($value,$name,$title='',$options,$allow_na='N/A',$extra='',$div=true)
{
	if(Preferences('HIDDEN')!='Y')
		$div = false;

	if ($value!='' && !$options[$value])
		$options[$value] = array($value,'<FONT color=red>'.$value.'</FONT>');
		
		$return = (((is_array($options[$value])?$options[$value][1]:$options[$value])!='')?(is_array($options[$value])?$options[$value][1]:$options[$value]):($allow_na!==false?($allow_na?$allow_na:'-'):'-')).($title!=''?'<BR><small>'.(strpos(strtolower($title),'<font ')===false?'<FONT color='.Preferences('TITLES').'>':'').$title.(strpos(strtolower($title),'<font ')===false?'</FONT>':'').'</small>':'');

	return $return;
}


###################################################################################################

###########################################################################
function GetStuListAttn(& $extra)
{	global $contacts_RET,$view_other_RET,$_openSIS;

	if((!$extra['SELECT_ONLY'] || strpos($extra['SELECT_ONLY'],'GRADE_ID')!==false) && !$extra['functions']['GRADE_ID'])
		$functions = array('GRADE_ID'=>'GetGrade');
	else
		$functions = array();

	if($extra['functions'])
		$functions += $extra['functions'];

	if(!$extra['DATE'])
	{
		$queryMP = UserMP();
		$extra['DATE'] = DBDate();
	}
	else{
	#	$queryMP = GetCurrentMP('QTR',$extra['DATE'],false);
                $queryMP = UserMP();
        }
	if($_REQUEST['expanded_view']=='true')
	{
		if(!$extra['columns_after'])
			$extra['columns_after'] = array();
#############################################################################################
//Commented as it crashing for Linux due to  Blank Database tables
		//$view_fields_RET = DBGet(DBQuery("SELECT cf.ID,cf.TYPE,cf.TITLE FROM program_user_config puc,custom_fields cf WHERE puc.TITLE=cf.ID AND puc.PROGRAM='StudentFieldsView' AND puc.USER_ID='".User('STAFF_ID')."' AND puc.VALUE='Y'"));
#############################################################################################
		$view_address_RET = DBGet(DBQuery('SELECT VALUE FROM program_user_config WHERE PROGRAM=\'StudentFieldsView\' AND TITLE=\'ADDRESS\' AND USER_ID=\''.User('STAFF_ID').'\''));
		$view_address_RET = $view_address_RET[1]['VALUE'];
		$view_other_RET = DBGet(DBQuery('SELECT TITLE,VALUE FROM program_user_config WHERE PROGRAM=\'StudentFieldsView\' AND TITLE IN (\'CONTACT_INFO\',\'HOME_PHONE\',\'GUARDIANS\',\'ALL_CONTACTS\') AND USER_ID=\''.User('STAFF_ID').'\''),array(),array('TITLE'));

		if(!count($view_fields_RET) && !isset($view_address_RET) && !isset($view_other_RET['CONTACT_INFO']))
		{
			$extra['columns_after'] = array('CONTACT_INFO'=>'<IMG SRC=assets/down_phone_button.gif border=0>','gender'=>''._('Gender').'','ethnicity'=>''._('Ethnicity').'','ADDRESS'=>''._('Mailing Address').'','CITY'=>''._('City').'','STATE'=>''._('State').'','ZIPCODE'=>''._('Zipcode').'') + $extra['columns_after'];
			$select = ',s.STUDENT_ID AS CONTACT_INFO,s.GENDER,s.ETHNICITY,COALESCE(a.MAIL_ADDRESS,a.ADDRESS) AS ADDRESS,COALESCE(a.MAIL_CITY,a.CITY) AS CITY,COALESCE(a.MAIL_STATE,a.STATE) AS STATE,COALESCE(a.MAIL_ZIPCODE,a.ZIPCODE) AS ZIPCODE ';
			$extra['FROM'] = ' LEFT OUTER JOIN students_join_address sam ON (ssm.STUDENT_ID=sam.STUDENT_ID AND sam.MAILING=\'Y\') LEFT OUTER JOIN address a ON (sam.ADDRESS_ID=a.ADDRESS_ID) '.$extra['FROM'];
			$functions['CONTACT_INFO'] = 'makeContactInfo';
			// if gender is converted to codeds type
			//$functions['CUSTOM_200000000'] = 'DeCodeds';
			$extra['singular'] = ''._('Student Address').'';
			$extra['plural'] = ''._('Student Addresses').'';

			$extra2['NoSearchTerms'] = true;
			$extra2['SELECT_ONLY'] = 'ssm.STUDENT_ID,p.PERSON_ID,p.FIRST_NAME,p.LAST_NAME,sjp.STUDENT_RELATION,pjc.TITLE,pjc.VALUE,a.PHONE,sjp.ADDRESS_ID ';
			$extra2['FROM'] .= ',address a,students_join_address sja LEFT OUTER JOIN students_join_people sjp ON (sja.STUDENT_ID=sjp.STUDENT_ID AND sja.ADDRESS_ID=sjp.ADDRESS_ID AND (sjp.CUSTODY=\'Y\' OR sjp.EMERGENCY=\'Y\')) LEFT OUTER JOIN people p ON (p.PERSON_ID=sjp.PERSON_ID) LEFT OUTER JOIN people_join_contacts pjc ON (pjc.PERSON_ID=p.PERSON_ID) ';
			$extra2['WHERE'] .= ' AND a.ADDRESS_ID=sja.ADDRESS_ID AND sja.STUDENT_ID=ssm.STUDENT_ID ';
			$extra2['ORDER_BY'] .= 'COALESCE(sjp.CUSTODY,\'N\') DESC';
			$extra2['group'] = array('STUDENT_ID','PERSON_ID');

			// EXPANDED VIEW AND ADDR BREAKS THIS QUERY ... SO, TURN 'EM OFF
			if(!$_REQUEST['_openSIS_PDF'])
			{
				$expanded_view = $_REQUEST['expanded_view'];
				$_REQUEST['expanded_view'] = false;
				$addr = $_REQUEST['addr'];
				unset($_REQUEST['addr']);
				$contacts_RET = GetStuList($extra2);
				$_REQUEST['expanded_view'] = $expanded_view;
				$_REQUEST['addr'] = $addr;
			}
			else
				unset($extra2['columns_after']['CONTACT_INFO']);
		}
		else
		{
			if($view_other_RET['CONTACT_INFO'][1]['VALUE']=='Y' && !$_REQUEST['_openSIS_PDF'])
			{
				$select .= ',NULL AS CONTACT_INFO ';
				$extra['columns_after']['CONTACT_INFO'] = '<IMG SRC=assets/down_phone_button.gif border=0>';
				$functions['CONTACT_INFO'] = 'makeContactInfo';

				$extra2 = $extra;
				$extra2['NoSearchTerms'] = true;
				$extra2['SELECT'] = '';
				$extra2['SELECT_ONLY'] = 'ssm.STUDENT_ID,p.PERSON_ID,p.FIRST_NAME,p.LAST_NAME,sjp.STUDENT_RELATION,pjc.TITLE,pjc.VALUE,a.PHONE,sjp.ADDRESS_ID,COALESCE(sjp.CUSTODY,\'N\') ';
				$extra2['FROM'] .= ',address a,students_join_address sja LEFT OUTER JOIN students_join_people sjp ON (sja.STUDENT_ID=sjp.STUDENT_ID AND sja.ADDRESS_ID=sjp.ADDRESS_ID AND (sjp.CUSTODY=\'Y\' OR sjp.EMERGENCY=\'Y\')) LEFT OUTER JOIN people p ON (p.PERSON_ID=sjp.PERSON_ID) LEFT OUTER JOIN people_join_contacts pjc ON (pjc.PERSON_ID=p.PERSON_ID) ';
				$extra2['WHERE'] .= ' AND a.ADDRESS_ID=sja.ADDRESS_ID AND sja.STUDENT_ID=ssm.STUDENT_ID ';
				$extra2['ORDER_BY'] .= 'COALESCE(sjp.CUSTODY,\'N\') DESC';
				$extra2['group'] = array('STUDENT_ID','PERSON_ID');
				$extra2['functions'] = array();
				$extra2['link'] = array();

				// EXPANDED VIEW AND ADDR BREAKS THIS QUERY ... SO, TURN 'EM OFF
				$expanded_view = $_REQUEST['expanded_view'];
				$_REQUEST['expanded_view'] = false;
				$addr = $_REQUEST['addr'];
				unset($_REQUEST['addr']);
				$contacts_RET = GetStuList($extra2);
				$_REQUEST['expanded_view'] = $expanded_view;
				$_REQUEST['addr'] = $addr;
			}
			foreach($view_fields_RET as $field)
			{
				$extra['columns_after']['CUSTOM_'.$field['ID']] = $field['TITLE'];
				if($field['TYPE']=='date')
					$functions['CUSTOM_'.$field['ID']] = 'ProperDate';
				elseif($field['TYPE']=='numeric')
					$functions['CUSTOM_'.$field['ID']] = 'removeDot00';
				elseif($field['TYPE']=='codeds')
					$functions['CUSTOM_'.$field['ID']] = 'DeCodeds';
				$select .= ',s.CUSTOM_'.$field['ID'];
			}
			if($view_address_RET)
			{
				$extra['FROM'] = " LEFT OUTER JOIN students_join_address sam ON (ssm.STUDENT_ID=sam.STUDENT_ID AND sam.".$view_address_RET."='Y') LEFT OUTER JOIN address a ON (sam.ADDRESS_ID=a.ADDRESS_ID) ".$extra['FROM'];
				$extra['columns_after'] += array('ADDRESS'=>ucwords(strtolower(str_replace('_',' ',$view_address_RET))).' Address','CITY'=>''._('City').'','STATE'=>''._('State').'','ZIPCODE'=>''._('Zipcode').'');
				if($view_address_RET!='MAILING')
					$select .= ',a.ADDRESS_ID,a.ADDRESS,a.CITY,a.STATE,a.ZIPCODE,a.PHONE,ssm.STUDENT_ID AS PARENTS';
				else
					$select .= ',a.ADDRESS_ID,COALESCE(a.MAIL_ADDRESS,a.ADDRESS) AS ADDRESS,COALESCE(a.MAIL_CITY,a.CITY) AS CITY,COALESCE(a.MAIL_STATE,a.STATE) AS STATE,COALESCE(a.MAIL_ZIPCODE,a.ZIPCODE) AS ZIPCODE,a.PHONE,ssm.STUDENT_ID AS PARENTS ';
				$extra['singular'] = ''._('Student Address').'';
				$extra['plural'] = ''._('Student Addresses').'';

				if($view_other_RET['HOME_PHONE'][1]['VALUE']=='Y')
				{
					$functions['PHONE'] = 'makePhone';
					$extra['columns_after']['PHONE'] = ''._('Home Phone').'';
				}
				if($view_other_RET['GUARDIANS'][1]['VALUE']=='Y' || $view_other_RET['ALL_CONTACTS'][1]['VALUE']=='Y')
				{
					$functions['PARENTS'] = 'makeParents';
					if($view_other_RET['ALL_CONTACTS'][1]['VALUE']=='Y')
						$extra['columns_after']['PARENTS'] = ''._('Contacts').'';
					else
						$extra['columns_after']['PARENTS'] = ''._('Guardians').'';
				}
			}
			elseif($_REQUEST['addr'] || $extra['addr'])
			{
				$extra['FROM'] = ' LEFT OUTER JOIN students_join_address sam ON (ssm.STUDENT_ID=sam.STUDENT_ID '.$extra['students_join_address'].') LEFT OUTER JOIN address a ON (sam.ADDRESS_ID=a.ADDRESS_ID) '.$extra['FROM'];
				$distinct = 'DISTINCT ';
			}
		}
		$extra['SELECT'] .= $select;
	}
	elseif($_REQUEST['addr'] || $extra['addr'])
	{
		$extra['FROM'] = ' LEFT OUTER JOIN students_join_address sam ON (ssm.STUDENT_ID=sam.STUDENT_ID '.$extra['students_join_address'].') LEFT OUTER JOIN address a ON (sam.ADDRESS_ID=a.ADDRESS_ID) '.$extra['FROM'];
		$distinct = 'DISTINCT ';
	}

	switch(User('PROFILE'))
	{
		case 'admin':
			$sql = 'SELECT ';
			if($extra['SELECT_ONLY'])
				$sql .= $extra['SELECT_ONLY'];
			else
			{
				if(Preferences('NAME')=='Common')
					$sql .= 'CONCAT(s.LAST_NAME,\', \',coalesce(s.COMMON_NAME,s.FIRST_NAME)) AS FULL_NAME,';
				else
					$sql .= 'CONCAT(s.LAST_NAME,\', \',s.FIRST_NAME,\' \',COALESCE(s.MIDDLE_NAME,\' \')) AS FULL_NAME,';
				$sql .='s.LAST_NAME,s.FIRST_NAME,s.MIDDLE_NAME,s.STUDENT_ID,ssm.SCHOOL_ID AS LIST_SCHOOL_ID,ssm.GRADE_ID '.$extra['SELECT'];
				if($_REQUEST['include_inactive']=='Y')
					$sql .= ','.db_case(array('(ssm.SYEAR=\''.UserSyear().'\' AND (ssm.START_DATE IS NOT NULL AND (\''.date('Y-m-d',strtotime($extra['DATE'])).'\'<=ssm.END_DATE OR ssm.END_DATE IS NULL)))','true',"'<FONT color=green>"._('Active')."</FONT>'","'<FONT color=red>"._('Inactive')."</FONT>'")).' AS ACTIVE ';
			}

			$sql .= ' FROM students s,student_enrollment ssm '.$extra['FROM'].' WHERE ssm.STUDENT_ID=s.STUDENT_ID ';
			if($_REQUEST['include_inactive']=='Y')
				$sql .= ' AND ssm.ID=(SELECT ID FROM student_enrollment WHERE STUDENT_ID=ssm.STUDENT_ID AND SYEAR<=\''.UserSyear().'\' ORDER BY START_DATE DESC LIMIT 1)';
			else
				$sql .= ' AND ssm.SYEAR=\''.UserSyear().'\' AND (ssm.START_DATE IS NOT NULL AND (\''.date('Y-m-d',strtotime($extra['DATE'])).'\'<=ssm.END_DATE OR ssm.END_DATE IS NULL)) ';

			if(UserSchool() && $_REQUEST['_search_all_schools']!='Y')
				$sql .= ' AND ssm.SCHOOL_ID=\''.UserSchool().'\'';
			else
			{
//				if(User('SCHOOLS'))
					$sql .= ' AND ssm.SCHOOL_ID IN ('.GetUserSchools(UserID(),true).') ';
				$extra['columns_after']['LIST_SCHOOL_ID'] = ''._('School').'';
				$functions['LIST_SCHOOL_ID'] = 'GetSchool';
			}

			if(!$extra['SELECT_ONLY'] && $_REQUEST['include_inactive']=='Y')
				$extra['columns_after']['ACTIVE'] = ''._('Status').'';
		break;

		case 'teacher':
			$sql = 'SELECT ';
			if($extra['SELECT_ONLY'])
				$sql .= $extra['SELECT_ONLY'];
			else
			{
				if(Preferences('NAME')=='Common')
					$sql .= 'CONCAT(s.LAST_NAME,\', \',coalesce(s.COMMON_NAME,s.FIRST_NAME)) AS FULL_NAME,';
				else
					$sql .= 'CONCAT(s.LAST_NAME,\', \',s.FIRST_NAME,\' \',COALESCE(s.MIDDLE_NAME,\' \')) AS FULL_NAME,';
				$sql .='s.LAST_NAME,s.FIRST_NAME,s.MIDDLE_NAME,s.STUDENT_ID,ssm.SCHOOL_ID,ssm.GRADE_ID '.$extra['SELECT'];
				if($_REQUEST['include_inactive']=='Y')
				{
					$sql .= ','.db_case(array('(ssm.START_DATE IS NOT NULL AND  (\''.$extra['DATE'].'\'<=ssm.END_DATE OR ssm.END_DATE IS NULL))','true',"'<FONT color=green>"._('Active')."</FONT>'","'<FONT color=red>"._('Inactive')."</FONT>'")).' AS ACTIVE';
					$sql .= ','.db_case(array('(\''.$extra['DATE'].'\'>=ss.START_DATE AND (\''.$extra['DATE'].'\'<=ss.END_DATE OR ss.END_DATE IS NULL))','true',"'<FONT color=green>"._('Active')."</FONT>'","'<FONT color=red>"._('Inactive')."</FONT>'")).' AS ACTIVE_SCHEDULE';
				}
			}

		#	$sql .= " FROM students s,course_periods cp,schedule ss,student_enrollment ssm ".$extra['FROM']." WHERE ssm.STUDENT_ID=s.STUDENT_ID AND ssm.STUDENT_ID=ss.STUDENT_ID AND ssm.SCHOOL_ID='".UserSchool()."' AND ssm.SYEAR='".UserSyear()."' AND ssm.SYEAR=cp.SYEAR AND ssm.SYEAR=ss.SYEAR AND ss.MARKING_PERIOD_ID IN (".GetAllMP('',$queryMP).") AND (cp.TEACHER_ID='".User('STAFF_ID')."' OR cp.SECONDARY_TEACHER_ID='".User('STAFF_ID')."') AND cp.COURSE_PERIOD_ID='".UserCoursePeriod()."' AND cp.COURSE_ID=ss.COURSE_ID AND cp.COURSE_PERIOD_ID=ss.COURSE_PERIOD_ID";
		
//			$sql .= " FROM students s,course_periods cp,schedule ss,student_enrollment ssm ".$extra['FROM']." WHERE ssm.STUDENT_ID=s.STUDENT_ID AND ssm.STUDENT_ID=ss.STUDENT_ID AND ssm.SCHOOL_ID='".UserSchool()."' AND ssm.SYEAR='".UserSyear()."' AND ssm.SYEAR=cp.SYEAR AND ssm.SYEAR=ss.SYEAR AND (cp.TEACHER_ID='".User('STAFF_ID')."' OR cp.SECONDARY_TEACHER_ID='".User('STAFF_ID')."') AND cp.COURSE_PERIOD_ID='".UserCoursePeriod()."' AND cp.COURSE_ID=ss.COURSE_ID AND cp.COURSE_PERIOD_ID=ss.COURSE_PERIOD_ID";
                        $sql .= ' FROM students s,course_periods cp,schedule ss,student_enrollment ssm '.$extra['FROM'].' WHERE ssm.STUDENT_ID=s.STUDENT_ID AND ssm.STUDENT_ID=ss.STUDENT_ID AND ssm.SCHOOL_ID=\''.UserSchool().'\' AND ssm.SYEAR=\''.UserSyear().'\' AND ssm.SYEAR=cp.SYEAR AND ssm.SYEAR=ss.SYEAR AND '.  db_case(array(User('STAFF_ID'),'cp.teacher_id',' cp.teacher_id='.  User('STAFF_ID'),'cp.secondary_teacher_id',' cp.secondary_teacher_id='.  User('STAFF_ID'),'cp.course_period_id IN(SELECT course_period_id from teacher_reassignment tra WHERE cp.course_period_id=tra.course_period_id AND tra.pre_teacher_id='.  User('STAFF_ID').')')).' AND cp.COURSE_PERIOD_ID=\''.UserCoursePeriod().'\' AND cp.COURSE_ID=ss.COURSE_ID AND cp.COURSE_PERIOD_ID=ss.COURSE_PERIOD_ID';
			if($_REQUEST['include_inactive']=='Y')
			{
				$sql .= ' AND ssm.ID=(SELECT ID FROM student_enrollment WHERE STUDENT_ID=ssm.STUDENT_ID AND SYEAR=ssm.SYEAR ORDER BY START_DATE DESC LIMIT 1)';
				$sql .= ' AND ss.START_DATE=(SELECT START_DATE FROM schedule WHERE STUDENT_ID=ssm.STUDENT_ID AND SYEAR=ssm.SYEAR AND MARKING_PERIOD_ID IN ('.GetAllMP('',$queryMP).') AND COURSE_ID=cp.COURSE_ID AND COURSE_PERIOD_ID=cp.COURSE_PERIOD_ID ORDER BY START_DATE DESC LIMIT 1)';
			}
			else
			{
				$sql .= ' AND (ssm.START_DATE IS NOT NULL  AND \''.$extra['DATE'].'\'>=ssm.START_DATE AND (\''.$extra['DATE'].'\'<=ssm.END_DATE OR ssm.END_DATE IS NULL))';
				$sql .= ' AND (\''.$extra['DATE'].'\'>=ss.START_DATE AND (\''.$extra['DATE'].'\'<=ss.END_DATE OR ss.END_DATE IS NULL))';
			}

			if(!$extra['SELECT_ONLY'] && $_REQUEST['include_inactive']=='Y')
			{
				$extra['columns_after']['ACTIVE'] = ''._('School Status').'';
				$extra['columns_after']['ACTIVE_SCHEDULE'] = ''._('Course Status').'';
			}
		break;

		case 'parent':
		case 'student':
			$sql = 'SELECT ';
			if($extra['SELECT_ONLY'])
				$sql .= $extra['SELECT_ONLY'];
			else
			{
				if(Preferences('NAME')=='Common')
					$sql .= 'CONCAT(s.LAST_NAME,\', \',coalesce(s.COMMON_NAME,s.FIRST_NAME)) AS FULL_NAME,';
				else
					$sql .= 'CONCAT(s.LAST_NAME,\', \',s.FIRST_NAME,\' \',COALESCE(s.MIDDLE_NAME,\' \')) AS FULL_NAME,';
				$sql .='s.LAST_NAME,s.FIRST_NAME,s.MIDDLE_NAME,s.STUDENT_ID,ssm.SCHOOL_ID,ssm.GRADE_ID '.$extra['SELECT'];
			}
			$sql .= ' FROM students s,student_enrollment ssm '.$extra['FROM'].'
					WHERE ssm.STUDENT_ID=s.STUDENT_ID AND ssm.SYEAR=\''.UserSyear().'\' AND ssm.SCHOOL_ID=\''.UserSchool().'\' AND (\''.DBDate().'\' BETWEEN ssm.START_DATE AND ssm.END_DATE OR (ssm.END_DATE IS NULL AND \''.DBDate().'\'>ssm.START_DATE)) AND ssm.STUDENT_ID'.($extra['ASSOCIATED']?' IN (SELECT STUDENT_ID FROM students_join_users WHERE STAFF_ID=\''.$extra['ASSOCIATED'].'\')':'=\''.UserStudentID().'\'');
		break;
		default:
			exit('Error');
	}

	$sql = appendSQL($sql,$extra);

	$sql .= $extra['WHERE'].' ';
	$sql .= CustomFields('where');

	if($extra['GROUP'])
		$sql .= ' GROUP BY '.$extra['GROUP'];

	if(!$extra['ORDER_BY'] && !$extra['SELECT_ONLY'])
	{
		if(Preferences('SORT')=='Grade')
			$sql .= ' ORDER BY (SELECT SORT_ORDER FROM school_gradelevels WHERE ID=ssm.GRADE_ID),FULL_NAME';
		else
			$sql .= ' ORDER BY FULL_NAME';
		$sql .= $extra['ORDER'];
	}
	elseif($extra['ORDER_BY'])
		$sql .= ' ORDER BY '.$extra['ORDER_BY'];

	if($extra['DEBUG']===true)
		echo '<!--'.$sql.'-->';
		
	return DBGet(DBQuery($sql),$functions,$extra['group']);
}

###########################################################################
########################validation functions#######################################
function scheduleAssociation($cp_id)
{
    $asso=DBGet(DBQuery('SELECT COURSE_PERIOD_ID FROM schedule WHERE COURSE_PERIOD_ID=\''.$cp_id.'\' LIMIT 0,1'));
    if($asso[1]['COURSE_PERIOD_ID']!='')
        return true;
}

function gradeAssociation($cp_id)
{
    $asso=DBGet(DBQuery('SELECT COURSE_PERIOD_ID FROM student_report_card_grades WHERE COURSE_PERIOD_ID=\''.$cp_id.'\' LIMIT 0,1'));
    if($asso[1]['COURSE_PERIOD_ID']!='')
        return true;
}
###########################################################################
?>