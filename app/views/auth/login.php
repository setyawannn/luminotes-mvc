<div class="flex-grow mt-4 flex flex-col"> <div class="mt-6">
        <h1 class="text-3xl font-medium">Sign In</h1>
        <p>Log in to access your notes and continue your learning journey with Luminotes.</p>
    </div>
    <div class="mt-12 flex flex-col flex-grow"> 
        <form id="loginForm" action="<?= BASEURL; ?>/auth/prosesLogin" method="POST" class="flex flex-col flex-grow">
            <div>
                <div class="flex flex-col gap-y-4"> 
                    <input type="email" id="email" name="email" placeholder="Email" class="p-2 border w-full rounded" required>
                    <input type="password" id="password" name="password" placeholder="Password" class="p-2 border w-full rounded" required>
                    <div class="text-sm text-right"> 
                        <a href="<?= BASEURL; ?>/auth/forgotPassword" class="text-black hover:underline">Forgot password?</a> 
                    </div>
                </div>
            </div>
            
            <div class="w-full flex flex-col mt-auto mb-4 justify-center items-center"> 
                <button type="submit" id="btn-submit-login" class="flex p-3 border w-full rounded justify-center bg-black text-white">Sign In</button>
                <p class="mt-2">Don't have an account? <a href="<?= BASEURL; ?>/auth/register" class="text-black hover:underline">Sign Up</a></p>
            </div>
        </form>
    </div>
</div>