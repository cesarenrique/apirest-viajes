Hola {{$user->name}}
Por favor verifícala usundo el siguiente enlace:
{{ route('verify',$user->verify_Token) }}
