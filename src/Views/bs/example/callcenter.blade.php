<h1>Callcenter example</h1>
<h2>Agents</h2>
{{$slug}}

{{dump($callcenters)}}
{{dump($users)}}
@foreach($users as $user)
 <li>{{$user->bsUser->firstName . " " . $user->bsUser->lastName}}</li>
@endforeach