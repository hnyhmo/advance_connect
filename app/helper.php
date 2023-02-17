<?php
// SEND EMAIL HERE
function sendEmail($d){

    try{
        Mail::send('emails.blank', ['html'=>$d->msg], function ($m) use ($d) {
            $m->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
            $m->subject($d->subject);
            $m->bcc('henry.hamor@ph.c3-interactive.com');

            if(is_array($d->to)){
                foreach($d->to as $a){                    
                    $m->to($a, $d->name);
                }
            }else{
                $m->to($d->to, $d->name);
            }

            
        });
    }catch(\Exception $err){
        print($err);
    }

}

function logThis($data){
    $d = [
        'type' => $data['type'],
        'action' => $data['action'],
        'item' => $data['item'],
        'user_id' => auth()->user()->id,
        'user_data' => json_encode(auth()->user()),
        'created_at' => date('Y-m-d H:i:s')
    ];
    \App\Models\Log::create($d);
}

function getDisclosureCategories($id){
    $f = \App\Models\DisclosureCategory::whereIn('id', \App\Models\DisclosureCategoryXFile::where('disclosure_file_id', $id)->pluck('disclosure_category_id'))->get();
    return $f;
}




function savePhoto($base64=''){

    list($type, $base64) = explode(';', $base64);
    list(, $base64)      = explode(',', $base64);
    $base64 = base64_decode($base64);
    $f = finfo_open();
    $mime = finfo_buffer($f, $base64, FILEINFO_MIME_TYPE);
    $ext = str_replace('image/', '', $mime);
    $new_filename = uniqid(date('ymdhis')).'-smc.';
    $upload = file_put_contents(storage_path('/app/public/images/extra/'.$new_filename.$ext), $base64);
    $webp_check = false;
    if($upload){
        $webp_check = convertImage($new_filename.$ext, $new_filename.'webp', storage_path('/app/public/images/extra/'));
    }
    $final_ext = ($webp_check)?'webp':$ext;
    return env('APP_ASSET_URL').'/storage/images/extra/'.$new_filename.$final_ext;
}

function cleanBase64Content($v){
    $cleanContent = $v;
    preg_match_all('/<img[^>]+>/i',$v, $result); 
    foreach( $result as $img_tag)
    {
        foreach( $img_tag as $itag)
        {
            preg_match('/(src)=("[^"]*")/i', $itag, $r);
            $rr = isset($r[2])?$r[2]:'';
            if (substr($rr, 1, 5) === 'data:'){
                $newURL = savePhoto($rr);
                $cleanContent = str_replace($rr, $newURL, $cleanContent);
            }
        }
        
    }
    return $cleanContent;
}

function getNewName($fname){
    $array = explode('.', $fname);
    $ext = end($array);
    $newname = uniqid();

    $webp = '';
    if(in_array(strtolower($ext), ['png', 'jpg', 'jpeg', 'pjpeg', 'pjp'])){
        $webp = $newname.'.webp';
    }
    return ['orig'=>$newname.'.'.$ext, 'webp'=>$webp];
}

function uploadImage($img, $path){
    $f = '';
    if($img != ''){
        $destinationPath = storage_path('/app/public').$path;
        $names = getNewName($img->getClientOriginalName());
        $fname = $names['orig'];
        $img->move($destinationPath,$fname);
        $f = $fname;
        if($names['webp'] != ''){
            convertImage($fname, $names['webp'], $destinationPath);
        }
    }
    return $f;
}

function uploadFile($file, $path){
    $f = '';
    if($file != ''){
        $destinationPath = storage_path('/app/public/').$path;
        $fname = $file->getClientOriginalName();
        $file->move($destinationPath,$fname);
        $f = $fname;
    }
    return $f;
}


function convertImage($name, $newName, $dir){
    try {
        $array = explode('.', $name);
        $ext = end($array);
        $img = '';
        
        if(in_array(strtolower($ext), ['jpg', 'jpeg', 'pjpeg', 'pjp'])){
            $img = imagecreatefromjpeg($dir . $name);
        }
        else if(in_array(strtolower($ext), ['png'])){
            $img = imagecreatefrompng($dir . $name);
        }
        else if(in_array(strtolower($ext), ['gif'])){
            $img = imagecreatefromgif($dir . $name);
        }

        if($img != ''){
            imagepalettetotruecolor($img);
            imagealphablending($img, true);
            imagesavealpha($img, true);
            if (function_exists('imagewebp'))
                imagewebp($img, $dir . $newName, 100);
            imagedestroy($img);
        }
    }
    catch(Exception $e) {

    }
    
    if (function_exists('imagewebp')){
        return true;
    }else{
        return false;
    }
}

function bannerStyles(){
    $f = ['home_page'=>'Home Page','inner'=>'Inner','image_only'=>'Image Only'];
    return $f;
}

function sliderStyles(){
    $f = [
        'card'=>'Card',
        'full_page'=>'Full Page Image',
        'card-multiple'=>'Card - Mutiple Items',
        'full_slide_image'=>'Full Slide Image',
        'full_page_image'=>'Full Page Image',
        'thumbnail_image'=>'Thumbnail Image'
    ];
    return $f;
}


function captionPositions(){
    $f = [
            "top left" => "Top Left",
            "top h-center" => "Top Center",
            "top right" => "Top Right",
            "v-center h-center" => "Center Center",
            "v-center left" => "Center Left",
            "v-center right" => "Center Right",
            "bottom left" => "Bottom Left",
            "bottom h-center" => "Bottom Center",
            "bottom right" => "Bottom Right",
        ];
    return $f;
}


function pageTypes(){
    $f = ['article_category'=>'Article Category', 'article'=>'Article / Page', 'disclosure_category'=>'Disclosure Category', 'disclosure_file'=>'Disclosure File'];
    return $f;
}


function getActions(){
    $f = ['View', 'Add', 'Edit', 'Delete', 'Export'];
    return $f;
}


function getSubMenu($subMenu, $cnt){
    $menu = $subMenu->orderBy('sort', 'asc')->where([
        ['title', '!=', NULL],
        [function($query){
            if(request()->title)
                $query->where('title', 'LIKE', '%'.request()->title.'%');
            if(request()->type)
                $query->where('type', 'LIKE', '%'.request()->type.'%');
            if(request()->has('status') && !is_null(request()->status)){
                $stat = (request()->status)?request()->status:0;
                $query->where('status', $stat);
            }
        
        }]
    ])->get();
    $html = "";
    foreach($menu as $k => $sb){
        $n = 1 + $k;
        $visi="";
        $stat="";
        if($sb->status == 0)
            $stat= "<span class='badge badge-danger ticker-option' data-id='".$sb->id."' data-val='1' data-table='menus' data-type='status'>Unpublished</span>";
        else
            $stat= "<span class='badge badge-success ticker-option' data-id='".$sb->id."' data-val='0' data-table='menus' data-type='status'>Published</span>";
        
            
        if($sb->hidden == 0)
            $visi= "<span class='badge badge-default ticker-option' data-id='".$sb->id."' data-val='1' data-table='menus' data-type='hidden'>Hidden</span>";
        else
            $visi= "<span class='badge badge-info ticker-option' data-id='".$sb->id."' data-val='0' data-table='menus' data-type='hidden'>Visible</span>";
    

        $html .=  "<tr>
                <th scope='row'>".$n."</th>
                <td>".$cnt.' '.$sb->title."</td>
                <td>".$sb->type."</td>
                <td class='text-center'>
                    ".$visi."
                </td>
                <td class='text-center'>
                    ".$stat."
                </td>
                <td class='options'>
                    <a href='". route('menu.edit', ['menu' => $sb->id]) ."'><span class='ti-pencil-alt color-primary'></span></a>
                    <a href='#' data-url='". route('menu.destroy', ['menu' => $sb->id]) ."' class='delete'><span class='ti-trash color-danger'></span></a>
                </td>
            </tr>";

        $html .= getSubMenu($sb->subMenu(), $cnt.'_');
    }
    return $html;
}



function checkFile($file){
    if(!is_file(storage_path('app/public/'.$file))) return null;
    return file_exists(storage_path('app/public/'.$file))?env('APP_ASSET_URL').'/storage/'.$file:null;
}

function checkWebP($file){
    if(!is_file(storage_path('app/public/'.$file))) return null;
    $array = explode('/', $file);
    $fname = end($array);
    $webpname = pathinfo($fname, PATHINFO_FILENAME).'.webp';

    array_pop($array);
    $new_path = implode('/', $array);
    return file_exists(storage_path('app/public/'.$new_path.'/'.$webpname))?env('APP_ASSET_URL').'/storage/'.$new_path.'/'.$webpname:null;
}













// API
function getSubMenuAPI($sub){
    $sub = $sub->orderBy('sort', 'asc')->where('status', 1)->get();
    $sm = [];
    foreach($sub as $m){
        $m->children = getSubMenuAPI($m->subMenu());
        $m->page = pageType($m->type, $m->type_id);
        $sm[] = $m;
    }

    return $sm;
}

function pageType($type, $id){
    $result = [];
    if($type){
        if($type == 'article_category'){
            $result = \App\Models\ArticleCategory::where('id', $id)->get();
        }
        else if($type == 'article'){
            $result = \App\Models\Article::where('id', $id)->get();

        }
        else if($type == 'disclosure_category'){
            $result = \App\Models\DisclosureCategory::where('id', $id)->get();

        }
        else if($type == 'disclosure_file'){
            $result = \App\Models\DisclosureFile::where('id', $id)->get();
        }
    }

    return $result;
}





function permission($mod_id, $type){
    $check_role_permission = \App\Models\Permission::where('module_id', $mod_id)->where('action', $type)->where('role_id', auth()->user()->role_id)->first();
    $check_user_permission = \App\Models\Permission::where('module_id', $mod_id)->where('action', $type)->where('user_id', auth()->user()->id)->first();

    if(!$check_role_permission && !$check_user_permission)
        abort(403, 'Unauthorized action.');
}

function permissionShow($mod_id, $type){
    $check_role_permission = \App\Models\Permission::where('module_id', $mod_id)->where('action', $type)->where('role_id', auth()->user()->role_id)->first();
    $check_user_permission = \App\Models\Permission::where('module_id', $mod_id)->where('action', $type)->where('user_id', auth()->user()->id)->first();

    return (!$check_role_permission && !$check_user_permission)?false:true;
}


function getPercentage($total, $number)
{
    $total = (($total- $number) / ($total)) * 100;
    return 100 - $total;
}



function getButtonType($type)
{   
    $type = strtolower($type);
    $msg = 'default';
    if($type == 'add')$type='success';
    if($type == 'delete')$type='danger';
    if($type == 'update')$type='warning';

    return $type;
}


function getMonths()
{   
    $months = [
        1 => ['month'=>'January', 'color'=> randomColor()],
        2 => ['month'=>'February', 'color'=> randomColor()],
        3 => ['month'=>'March', 'color'=> randomColor()],
        4 => ['month'=>'April', 'color'=> randomColor()],
        5 => ['month'=>'May', 'color'=> randomColor()],
        6 => ['month'=>'June', 'color'=> randomColor()],
        7 => ['month'=>'July', 'color'=> randomColor()],
        8 => ['month'=>'August', 'color'=> randomColor()],
        9 => ['month'=>'September', 'color'=> randomColor()],
        10 => ['month'=>'October', 'color'=> randomColor()],
        11 => ['month'=>'November', 'color'=> randomColor()],
        12 => ['month'=>'December', 'color'=> randomColor()],
    ];

    return $months;

}

function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}
function randomColor() {
    return random_color_part() . random_color_part() . random_color_part();
}


function get_size($bytes){
    $si_prefix = array( 'B', 'KB', 'MB', 'GB', 'TB', 'EB', 'ZB', 'YB' );
    $base = 1024;
    $class = min((int)log($bytes , $base) , count($si_prefix) - 1);
    
    return sprintf('%1.2f' , $bytes / pow($base,$class)) . ' ' . $si_prefix[$class];
}


function getStock($item_id, $warehouse_id=false, $max_date=''){
    $date = ($max_date)?$max_date:date('Y-m-d');
    $stocks = \App\Models\Stock::where('item_id', $item_id);
    if($warehouse_id){
        $stocks = $stocks->where('warehouse_id', $warehouse_id);
    }
    $stocks = $stocks->whereDate('date', '<=', $date)->orderBy('date', 'desc')->get();

    $total = 0;

    foreach($stocks as $s){
        if($s->type == 'in')
            $total += $s->stock;
        if($s->type == 'out')
            $total -= $s->stock;
    }

    return $total;
 
}



function getTransactionTotal($trans_id){
    $stocks = \App\Models\Stock::where('transaction_id', $trans_id)->orderBy('date', 'desc')->get();

    $total = 0;

    foreach($stocks as $s){
        $total += $s->price * $s->stock;
    }

    return $total;
 
}
