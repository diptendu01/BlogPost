<x-profile :sharedData="$sharedData" :sharedData="$sharedData" doctitle="{{$sharedData['username']}}'s Following">
    @include('profile-following-only')
  </x-profile>