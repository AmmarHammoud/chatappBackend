@component('mail::message')
{{-- عنوان الرسالة --}}
# {{ __('Verification Code') }}

{{-- نص الوصف --}}
<p style="font-size: 18px; color: #2d3748; text-align: center; line-height: 1.6;">
    We are thrilled to have you with us! To complete your registration, please enter the verification code below.
</p>

{{-- رمز التحقق --}}
@component('mail::panel')
<div style="background-color: #F0F4F8; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); text-align: center;">
    <p style="font-size: 22px; font-weight: 600; color: #374151;">{{ __('Your Verification Code:') }}</p>
    <p style="font-size: 36px; font-weight: bold; color: #FF6F61; letter-spacing: 5px; margin: 0;">
        {{ $code }}
    </p>
</div>
@endcomponent

{{-- ملاحظة اضافية --}}
<p style="font-size: 16px; color: #6B7280; text-align: center; margin-top: 20px;">
    This code will expire in <strong>10 minutes</strong>. Please verify your email before it expires.
</p>

{{-- خاتمة --}}
<p style="font-size: 16px; color: #4A5568; text-align: center; margin-top: 30px;">
    Thank you for using our service,<br>
    <strong>{{ config('app.name') }}</strong>
</p>

{{-- نص فرعي --}}
@slot('footer')
@component('mail::subcopy')
If you’re having trouble using the verification code, please contact our <a href="mailto:support@example.com" style="color: #FF6F61; text-decoration: underline;">support team</a> for assistance.
@endcomponent
@endslot

@endcomponent
