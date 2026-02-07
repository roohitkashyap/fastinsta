@extends('layouts.app')

@section('content')
<div class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Terms of Service</h1>
        <p class="text-gray-500 mb-8">Last updated: {{ date('F d, Y') }}</p>
        
        <div class="prose prose-lg max-w-none">
            <h2>1. Acceptance of Terms</h2>
            <p>
                By accessing and using FastInsta, you accept and agree to be bound by these 
                Terms of Service. If you disagree with any part of these terms, you may not 
                use our service.
            </p>
            
            <h2>2. Description of Service</h2>
            <p>
                FastInsta provides a tool to download publicly available content from Instagram.
                We do not host, store, or have control over the content that users download.
            </p>
            
            <h2>3. User Responsibilities</h2>
            <p>You agree to:</p>
            <ul>
                <li>Only download content you have the right to use</li>
                <li>Respect copyright and intellectual property rights</li>
                <li>Not use the service for any illegal purposes</li>
                <li>Not abuse or overload our service</li>
                <li>Not attempt to bypass any rate limits or security measures</li>
            </ul>
            
            <h2>4. Intellectual Property</h2>
            <p>
                Content downloaded through FastInsta remains the property of its original creators.
                Downloaded content should only be used for personal, non-commercial purposes 
                unless you have explicit permission from the content owner.
            </p>
            
            <h2>5. Disclaimer of Warranties</h2>
            <p>
                FastInsta is provided "as is" without any warranties, express or implied. We do 
                not guarantee that the service will be uninterrupted or error-free.
            </p>
            
            <h2>6. Limitation of Liability</h2>
            <p>
                FastInsta shall not be liable for any damages arising from the use or inability 
                to use our service, including but not limited to direct, indirect, incidental, 
                or consequential damages.
            </p>
            
            <h2>7. Third-Party Links</h2>
            <p>
                Our service may contain links to third-party websites. We are not responsible 
                for the content or practices of these sites.
            </p>
            
            <h2>8. Modifications</h2>
            <p>
                We reserve the right to modify these terms at any time. Continued use of the 
                service after changes constitutes acceptance of the new terms.
            </p>
            
            <h2>9. Termination</h2>
            <p>
                We reserve the right to refuse service to anyone at any time for any reason.
            </p>
            
            <h2>10. Contact</h2>
            <p>
                For questions about these Terms of Service, please <a href="{{ route('contact') }}">contact us</a>.
            </p>
        </div>
    </div>
</div>
@endsection
