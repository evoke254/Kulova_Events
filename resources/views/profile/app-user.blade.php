<div class=" px-3  mt-8 ">
    <div class="flex flex-row justify-center">


        <div class="  md:w-1/2">
            <div class="grid sm:grid-cols-1 md:grid-cols-2">

                <div class="px-4 sm:px-0">
                    <h3 class="text-base font-semibold leading-7 text-gray-950 dark:text-gray-200">User Information</h3>
                    <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-800 dark:text-gray-200">Personal details.</p>
                </div>
                @if($user->avata)
                    <img class="rounded-full w-28 mr-3 " src="{{$user->picture}}">
                @else
                    <x-avatar xl label="{{ $user->abbreviation }}"  class="mr-3"/>
                @endif
            </div>
            <div class="mt-6 ">
                <dl class="divide-y divide-gray-300">
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-200">Full name</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200">{{$user->title}}. {{$user->name}}</dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-200">Email</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200">
                            {{$user->email}}</dd>
                    </div>

                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-200">Role</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200">{{$user->role_name}}</dd>
                    </div>
              {{--}}      <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-200">Referral Link</dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200">
                            {{ route('package.purchase') }}?ref_code=value
                            <x-button.circle secondary icon="clipboard-list" class="ml-3"   id="copyReferral"  />
                            <input type="text" value="{{ route('package.purchase') }}?ref_code=value" id="copyReferralCode" style="display:none">
                        </dd>
                    </div>
                    <div class="px-4 py-6 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-0">
                        <dt class="text-sm font-medium leading-6 text-gray-900 dark:text-gray-200">Commission (%) </dt>
                        <dd class="mt-1 text-sm leading-6 text-gray-700 sm:col-span-2 sm:mt-0 dark:text-gray-200">
                            {{$user->commission ?? 0}} %
                        </dd>
                    </div> --}}



                </dl>
            </div>
        </div>

    </div>
</div>

<script>


    function copyText() {
        var copyReferralCode = document.getElementById('copyReferralCode');
        copyReferralCode.select();
        navigator.clipboard.writeText(copyReferralCode.value)
            .then(function() {
                window.$wireui.notify({
                    title: 'Text copied !',
                    description: copyReferralCode.value,
                    icon: 'success'
                })
            })
            .catch(function(err) {
                console.error('Unable to copy text: ', err);
            });
    }
</script>
