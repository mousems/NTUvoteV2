<?php
class Auth_core_model extends CI_Model {
    /**
    * MIT License (MIT)
    * Copyright (c) 2014 MouseMs <mousems.kuo@gmail.com>
    * http://opensource.org/licenses/MIT
    * https://github.com/mousems/NTUVoteV2
    **/
    

    function __construct()
    {
        // 呼叫模型(Model)的建構函數
        parent::__construct();
    }

    function whether_voted($student_id)
    {
        $this->db->from('auth_studata')->where('student_id', $student_id)->join('dept_name','dept_name.dept_id=auth_studata.dept_id');
        $query = $this->db->get();
        if($query->num_rows()==0){
            return "student_notfound";
        }else{
            $result = $query->result();
            if (isset($result[0])) {
                if($result[0]->{'step'} == 0){
                    return $result[0]->{'dept_name'};
                }else{
                    return "already_vote";
                }
            }
        }
    }


    function get_stu_data($student_id)
    {

        // 假設此學生存在資料裡，使用此功能要先確定學號存在

        // check special list first
        $this->db->from('special_student')->where('student_id', $student_id)->join('ballot_list','ballot_list.prefix=special_student.prefix');
        $query = $this->db->get();
        if($query->num_rows()!=0){
            $result = $query->result();
            if (isset($result[0])) {
                return array($result[0]->{'prefix'},$result[0]->{'name'});
            }
        }

        // get dept_id

        $this->db->from('auth_studata')->where('student_id', $student_id)->join('dept_name','dept_name.dept_id=auth_studata.dept_id')->join('ballot_list','ballot_list.prefix=dept_name.prefix');
        $query = $this->db->get();
        if($query->num_rows()!=0){
            $result = $query->result();
            if (isset($result[0])) {
                return array($result[0]->{'prefix'},$result[0]->{'name'});
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
        }

    }


    function set_vote_step($student_id)
    {

        $this->db->where('student_id',$student_id);
        $this->db->update('auth_studata', array(
            'step'=>'1',
            "a_id"=>$this->session->userdata('a_id')

        ));
        if ($this->db->affected_rows()>0) {
            return TRUE;
        }else{
            return FALSE;
        }

    }

    function get_voted_people($a_id)
    {
        $this->db->from('auth_studata')->where('a_id', $a_id);
        $query = $this->db->get();
        return $query->num_rows();
    }

}

?>