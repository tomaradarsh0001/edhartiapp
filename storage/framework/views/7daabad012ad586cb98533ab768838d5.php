
<?php $__env->startSection('title', 'Login'); ?>

<?php $__env->startSection('content'); ?>
<div class="login-8">

    <div class="container">
        <div class="row login-box">
            <div class="col-lg-12">
                <div class="fixed_login_container">
                    <div class="title">
                        <div class="bottom-container">
                            Welcome to eDharti
                        </div>
                        <div class="top-container">
                            Welcome to eDharti
                        </div>
                    </div>
                    
                </div>
            </div>
            <div class="col-lg-3">
                <figure class="swing">
                    <div class="wall-swing">
                      <p>Important Notice</p>
                      <ul>
                        <li><a href="#"><i class="fa-solid fa-arrow-right-long"></i> e-Dharti Geo-Portal 2.0</a></li>
                        <li><a href="#"><i class="fa-solid fa-arrow-right-long"></i> e-Dharti</a></li>
                        <li><a href="/appointment-detail"><i class="fa-solid fa-arrow-right-long"></i> Office Visit Appointment</a></li>
                        <li><a href="#"><i class="fa-solid fa-arrow-right-long"></i> Club Membership</a></li>
                      </ul>
                    </div>
                  </figure>
            </div>
            <div class="col-lg-6 mx-auto form-section">
                <div class="form-inner">
                    
                    <h3>Login</h3>

                    <div class="form-group form-box">
                        <input id="mobileInput" type="text" name="SeletedMobile" class="form-control" placeholder="Registered Mobile Number">
                    </div>
                    <div id="mobileLoginForm">
                        <div id="mobileOtp">
                            <div class="form-group form-box">
                                <input id="otpMobile" maxlength="10" type="text" name="otpMobile" :value="old('otpMobile')" required autofocus class="form-control" placeholder="Registered Mobile Number">
                                <div class="text-danger text-start" id="login_verify_mobile_otp_error"></div>
                            </div>
                            <div class="form-group">
                                <button id="getOtp" type="button" class="btn btn-primary btn-lg btn-theme">Get OTP</button>
                            </div>
                            <p><a href="<?php echo e(url('login')); ?>" class="thembo">Login with Username</a></p>
                        </div>
                        <div id="LoginWithOTP">
                            <form>
                                <div class="form-group form-box">
                                    <input id="mobile" maxlength="10" type="text" name="mobile" required autofocus class="form-control" placeholder="Registered Mobile Number">
                                </div>
                                <div class="form-group form-box">
                                    <input id="otp" maxlength="6" type="text" name="otp" required autofocus class="form-control" placeholder="Enter 6 digit OTP">
                                    <div class="text-danger text-start" id="login_form_verify_mobile_otp_error"></div>
                                </div>
                                <div class="form-group">
                                    <button type="button" id="verifyLoginOtp" class="btn btn-primary btn-lg btn-theme"><?php echo e(__('Log in')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <h6 class="text-divider" id="dividerLogin"><span>OR</span></h6>
                    <div class="form-group form-box">
                        <input id="emailInput" type="text" name="SeletedEmail" class="form-control" placeholder="Email Address">
                    </div>
                    <div id="emailLoginForm">
                        <form method="POST" action="<?php echo e(route('login')); ?>">
                            <?php echo csrf_field(); ?>
                            <div class="form-group form-box">
                                <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" class="form-control" placeholder="Email Address" aria-label="Email Address">
                            </div>
                            <div class="form-group form-box">
                                <input id="password"
                                type="password"
                                name="password"
                                required class="form-control" autocomplete="off" placeholder="Password" aria-label="Password">
                            </div>
                            <?php if (isset($component)) { $__componentOriginalf94ed9c5393ef72725d159fe01139746 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf94ed9c5393ef72725d159fe01139746 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.input-error','data' => ['messages' => $errors->get('email'),'class' => 'mt-2 fs-6 text-danger']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('input-error'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['messages' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($errors->get('email')),'class' => 'mt-2 fs-6 text-danger']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $attributes = $__attributesOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__attributesOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf94ed9c5393ef72725d159fe01139746)): ?>
<?php $component = $__componentOriginalf94ed9c5393ef72725d159fe01139746; ?>
<?php unset($__componentOriginalf94ed9c5393ef72725d159fe01139746); ?>
<?php endif; ?>
                            <?php if(session('failure')): ?>
                                <div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
                                    <div class="text-white"><?php echo e(session('failure')); ?></div>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <div class="checkbox form-group clearfix">
                                <!-- <div class="form-check float-start">
                                    <input class="form-check-input" type="checkbox" id="rememberme">
                                    <label class="form-check-label" for="rememberme">
                                        Remember me
                                    </label>
                                </div> -->
                                <a href="#" class="float-end forgot-password">Forgot your password?</a>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-theme"><?php echo e(__('Log in')); ?></button>
                                
                            </div>
                            
                        </form>
                        <p><a href="<?php echo e(url('login')); ?>" class="thembo">Login with Mobile Number</a></p>
                    </div>
                    <div class="clearfix"></div>
                    <p>Don't have an account? <a href="<?php echo e(route('publicRegister')); ?>" class="thembo"> Register here</a></p>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="gallery">
                    <div class="block-33 display--inline-top">
                            <div class="gutter relative">
                                <div class="gallery-h">
                                    <div class="gallery-image relative">
                                        <div class="gallery-image__img relative">
                                            <div class="fill-dimensions cover-img" style="background-image:url('<?php echo e(asset('assets/frontend/assets/img/slider/Golf-Course-Club.jpg')); ?>')"></div>
                                            <h5>Golf Course Club</h5>
                                        </div>
                                    </div>
                                    <div class="gallery-image">
                                        <div class="gallery-image__img relative">
                                            <div class="fill-dimensions cover-img" style="background-image:url('<?php echo e(asset('assets/frontend/assets/img/slider/habitat-center.jpg')); ?>')"></div>
                                            <h5>Habitat Center</h5>
                                        </div>
                                    </div>
                                    <div class="gallery-image">
                                        <div class="gallery-image__img relative">
                                            <div class="fill-dimensions cover-img" style="background-image:url('<?php echo e(asset('assets/frontend/assets/img/slider/india-gate.jpg')); ?>')"></div>
                                            <h5>India Gate</h5>
                                        </div>
                                    </div>
                                    <div class="gallery-image">
                                        <div class="gallery-image__img relative">
                                            <div class="fill-dimensions cover-img" style="background-image:url('<?php echo e(asset('assets/frontend/assets/img/slider/Parliament-house.jpg')); ?>')"></div>
                                            <h5>Parliament House</h5>
                                        </div>
                                    </div>
                                    <div class="gallery-image">
                                        <div class="gallery-image__img relative">
                                            <div class="fill-dimensions cover-img" style="background-image:url('<?php echo e(asset('assets/frontend/assets/img/slider/rasthtrapati-bhawan.jpg')); ?>')"></div>
                                            <h5>rasthtrapati Bhawan</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
    </div>
    <div class="ocean">
        <div class="wave"></div>
        <div class="wave"></div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\shubh\Desktop\new 22 august\eDharti\resources\views/auth/login.blade.php ENDPATH**/ ?>