<div class="flex-grow mt-4 flex flex-col"> <a href="<?= BASEURL; ?>/auth/login" class="flex mb-2"> <img src="<?= BASEURL; ?>/img/icons/arrow-back.svg" alt="arrow-back">Back to sign in
    </a>
    <div class="mt-6"> <h1 class="text-3xl font-medium">Sign Up</h1>
        <p>Create an account now to start sharing and discovering study materials with ease.</p>
    </div>
    <div class="mt-8 flex flex-col flex-grow"> 
        <form id="registerForm" action="<?= BASEURL; ?>/auth/prosesRegister" method="POST" class="flex flex-col flex-grow">
            <div>
                <div class="flex flex-col gap-y-4"> 
                    <input type="text" id="name" name="name" placeholder="Full Name" class="p-2 border w-full rounded" required>
                    <input type="email" id="email" name="email" placeholder="Email" class="p-2 border w-full rounded" required>
                    <input type="password" id="password" name="password" placeholder="Password" class="p-2 border w-full rounded" required>
                    <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" class="p-2 border w-full rounded" required>
                </div>
            </div>
            
            <div class="w-full flex flex-col mt-auto mb-6 justify-center items-center"> 
                <button type="submit" id="btn-submit" class="flex p-3 border w-full rounded justify-center bg-black text-white">Sign Up</button>
                <p class="mt-2">Already have account? <a href="<?= BASEURL; ?>/auth/login" class="text-black hover:underline">Sign In</a></p>
            </div>
        </form>
    </div>
</div>