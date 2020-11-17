<p>От {{ (isset($data['name']) && !empty($data['name']))? $data['name']:'' }} {{ (isset($data['email']) && !empty($data['email']))? '<'.$data['email'].'>': '' }}</p>
<p>
     {!!  (isset($data['name']) && !empty($data['name']))? 'Имя: '.$data['name'].'<br/>':''  !!}
    {!! (isset($data['email']) && !empty($data['email']))? 'E-mail: '.$data['email'].'<br/>':'' !!}
    {!! (isset($data['phone']) && !empty($data['phone']))? 'Телефон: '.$data['phone'].'<br/>':'' !!}
    {!! (isset($data['message']) && !empty($data['message']))? 'Сообщение:<br> '.$data['message']:'' !!}
    {!! (isset($data['detailTitle']) && !empty($data['detailTitle']))? 'Название услуги: '.$data['detailTitle']:'' !!}
</p>

{!! (isset($data['image']) && !empty($data['image']))?'<p><img src="'. $data['image'].'" /></p>':''!!}
<p>
    <hr>
</p>
<p>Это сообщение отправлено с сайта Alice Group (http://alicegroup.ru)</p>
