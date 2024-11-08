
<h2>{{ $user->name }} - Profil</h2>
<p>Email: {{ $user->email }}</p>
<p>Ro'yxatdan o'tgan: {{ $user->created_at->format('d-m-Y') }}</p>
<a href="{{ route('user.profile.edit') }}">Profilni tahrirlash</a>
