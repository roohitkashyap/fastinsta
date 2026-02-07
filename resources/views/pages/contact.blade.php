@extends('layouts.app')

@section('content')
<div class="py-16">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Contact Us</h1>
        
        <div class="grid md:grid-cols-2 gap-12">
            <div>
                <p class="text-lg text-gray-600 mb-6">
                    Have a question, suggestion, or feedback? We'd love to hear from you!
                </p>
                
                <div class="space-y-4">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-brand-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">Email</h3>
                            <p class="text-gray-600">support@fastinsta.com</p>
                        </div>
                    </div>
                    
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-brand-500 mt-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-gray-900">Response Time</h3>
                            <p class="text-gray-600">We aim to respond within 24 hours</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg p-8 border border-gray-100">
                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" id="name" name="name" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" required
                               class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                    </div>
                    
                    <div>
                        <label for="subject" class="block text-sm font-medium text-gray-700 mb-1">Subject</label>
                        <select id="subject" name="subject"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-transparent">
                            <option>General Inquiry</option>
                            <option>Bug Report</option>
                            <option>Feature Request</option>
                            <option>Partnership</option>
                        </select>
                    </div>
                    
                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-1">Message</label>
                        <textarea id="message" name="message" rows="4" required
                                  class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:ring-2 focus:ring-brand-500 focus:border-transparent"></textarea>
                    </div>
                    
                    <button type="submit" class="w-full py-3 px-4 gradient-bg text-white font-semibold rounded-xl hover:opacity-90 transition">
                        Send Message
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
