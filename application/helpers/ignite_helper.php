<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('authorize')) {
  function authorize($menu, $field)
  {
    if ($menu[$field] == false) redirect(site_url() . '/error/403');
  }
}

if (!function_exists('get_cookie_menu')) {
  function get_cookie_menu($menu_id)
  {
    $menu_id = str_replace('.', '_', $menu_id);
    $CI = get_instance();
    if (is_null(get_cookie($menu_id))) {
      $val = array(
        'search' => null,
        'per_page' => null,
        'cur_page' => null,
        'total_rows' => null,
        'order' => null
      );
      $cookie = array(
        'name'   => $menu_id,
        'value'  => json_encode($val),
        'expire' => '120'
      );
      $CI->input->set_cookie($cookie);
      return $val;
    } else {
      return json_decode(get_cookie($menu_id), TRUE);
    }
  }
}

if (!function_exists('set_cookie_menu')) {
  function set_cookie_menu($menu_id, $cookie_val)
  {
    $menu_id = str_replace('.', '_', $menu_id);
    $CI = get_instance();
    $cookie = array(
      'name'   => $menu_id,
      'value'  => json_encode($cookie_val),
      'expire' => '120'
    );
    $CI->input->set_cookie($cookie);
  }
}

if (!function_exists('set_pagination')) {
  function set_pagination($menu, $data, $id = null)
  {
    $CI = get_instance();
    $config['per_page'] = $data['per_page'];
    $config['base_url'] = site_url() . '/' . $menu['url'] . '/index/' . $id;
    $config['total_rows'] = $data['total_rows'];
    $CI->pagination->initialize($config);
  }
}

if (!function_exists('pagination_info')) {
  function pagination_info($list_rows, $data)
  {
    $str = '<i class="fas fa-eye"></i> Tampil ';
    if ($list_rows == 0) {
      $str .= '0 - 0 dari 0';
    } else {
      if ($list_rows > 0) {
        $str .= ($data['cur_page'] + 1);
      } else {
        $str .= ($data['cur_page']);
      }
      $str .= " - " . ($data['cur_page'] + $list_rows) . " dari " . $data['total_rows'];
    }
    $str .= " data";
    return $str;
  }
}

if (!function_exists('create_log')) {
  function create_log($access = 1, $module = "")
  {
    $CI = get_instance();

    $acc = $CI->db->where('id', $access)->get('access')->row_array();

    if ($CI->agent->is_browser()) {
      $agent = $CI->agent->browser() . ' ' . $CI->agent->version();
    } elseif ($CI->agent->is_robot()) {
      $agent = $CI->agent->robot();
    } elseif ($CI->agent->is_mobile()) {
      $agent = $CI->agent->mobile();
    } else {
      $agent = 'Unidentified';
    }

    $data = array(
      'user_id' => @$CI->session->userdata('user_id'),
      'session_id' => @$CI->session->session_id,
      'fullname' => @$CI->session->userdata('fullname'),
      'access' => @$acc['access'],
      'ip_address' => @$CI->input->ip_address(),
      'user_agent' => @$agent,
      'platform' => @$CI->agent->platform(),
      'module' => @$module,
      'url' => @current_url(),
      'description' => @$acc['description'],
      'created' => @date('Y-m-d H:i:s')
    );

    $file = APPPATH . 'logs/access-' . date('Y-m-d') . '.json';
    $log = json_decode(read_file($file));
    if ($log === null) {
      $log = array();
    };
    array_push($log, $data);
    write_file($file, json_encode($log), 'w+');
  }
}

if (!function_exists('table_sort')) {
  function table_sort($menu_id, $title, $field, $order)
  {
    $url = ($order['type'] == 'asc') ? 'desc' : 'asc';
    $icon = ($order['type'] == 'asc') ? 'sort-up' : 'sort-down';
    if ($order['field'] == $field) :
      return '<a class="text-dark" href="' . site_url() . '/app/order/' . $menu_id . '/' . $field . '/' . $url . '">' . $title . ' <i class="fa fa-' . $icon . '"></i></a>';
    else :
      return '<a class="text-dark" href="' . site_url() . '/app/order/' . $menu_id . '/' . $field . '/asc">' . $title . ' <i class="fa fa-sort"></i></a>';
    endif;
  }
}

if (!function_exists('reverse_date')) {
  function reverse_date($date = null, $sp = null, $tp = null, $sp2 = null)
  {
    if ($date != '') {
      if ($tp == 'date') {
        $arr_date = explode(' ', $date);
        $date = $arr_date[0];
      } elseif ($tp == 'full_date') {
        $arr_date = explode(' ', $date);
        $date = $arr_date[0];
        $time = $arr_date[1];
      }
      $arr = explode('-', $date);
      if ($sp != '') {
        $result = $arr[2] . $sp . $arr[1] . $sp . $arr[0];
      } else {
        $result = $arr[2] . '-' . $arr[1] . '-' . $arr[0];
      }
      if ($tp == 'full_date') {
        if ($sp2 != '') {
          $result .= $sp2 . $time;
        } else {
          $result .= ' ' . $time;
        }
      }
    } else {
      $result = '';
    }
    return $result;
  }
}

if (!function_exists('num_sys')) {
  function num_sys($val = null)
  {
    $val = str_replace('.', '', $val);
    $val = str_replace(',', '.', $val);
    return $val;
  }
}

if (!function_exists('num_id')) {
  function num_id($v, $s = null)
  {
    if (is_numeric($v)) {
      $res = number_format($v, 0, ",", ".");
      if ($s != null && $v == 0) return $s;
      else return $res;
    } else {
      return $s;
    }
  }
}
