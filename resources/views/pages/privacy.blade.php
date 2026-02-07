@extends('layouts.app')

@section('content')
<div class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Privacy Policy</h1>
        <p class="text-gray-500 mb-8">Last updated: {{ date('F d, Y') }}</p>
        
        <div class="prose prose-lg max-w-none">
            <h2>1. Information We Collect</h2>
            <p>
                FastInsta is designed with privacy in mind. We collect minimal information necessary
                to provide our service:
            </p>
            <ul>
                <li><strong>Instagram URLs:</strong> The URLs you paste to download content (not stored permanently)</li>
                <li><strong>Usage Analytics:</strong> Anonymous usage statistics to improve our service</li>
                <li><strong>IP Address:</strong> Temporarily logged for rate limiting and security</li>
            </ul>
            
            <h2>2. What We Don't Collect</h2>
            <ul>
                <li>We never ask for your Instagram login credentials</li>
                <li>We don't store the content you download</li>
                <li>We don't create user accounts or profiles</li>
            </ul>
            
            <h2>3. Cookies</h2>
            <p>
                We use essential cookies to ensure the website functions properly. We may also use
                analytics cookies (like Google Analytics) to understand how visitors use our site.
            </p>
            
            <h2>4. Third-Party Services</h2>
            <p>
                We may use third-party services for:
            </p>
            <ul>
                <li>Analytics (Google Analytics)</li>
                <li>Advertising (Google AdSense)</li>
                <li>Security (Cloudflare)</li>
            </ul>
            <p>Each of these services has their own privacy policy.</p>
            
            <h2>5. Data Security</h2>
            <p>
                We implement appropriate security measures to protect against unauthorized access.
                All connections to our website are encrypted using HTTPS.
            </p>
            
            <h2>6. Children's Privacy</h2>
            <p>
                Our service is not intended for children under 13. We do not knowingly collect
                information from children.
            </p>
            
            <h2>7. Changes to This Policy</h2>
            <p>
                We may update this Privacy Policy from time to time. We will notify you of any
                changes by posting the new policy on this page.
            </p>
            
            <h2>8. Contact Us</h2>
            <p>
                If you have questions about this Privacy Policy, please <a href="{{ route('contact') }}">contact us</a>.
            </p>
        </div>
    </div>
</div>
@endsection
