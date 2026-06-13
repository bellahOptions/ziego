@extends('layouts.app')
@section('title', 'Contact Us — Ziego Furniture & Interiors')

@section('content')
<div class="pt-20">
    <div class="py-14 px-4 sm:px-6 relative" style="background: linear-gradient(135deg, var(--brand-dark) 0%, #5A2D00 100%);">
        <div class="max-w-4xl mx-auto text-center">
            <h1 class="text-4xl font-bold text-white mb-3" style="font-family: 'Calistoga', serif;">Get In Touch</h1>
            <p class="text-white/70">We'd love to hear from you. Let's create your perfect space together.</p>
        </div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-16">
        <div class="grid lg:grid-cols-2 gap-12">

            {{-- Contact Form --}}
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8">
                <h2 class="text-2xl font-bold mb-6" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Send Us a Message</h2>

                <form action="{{ route('contact.send') }}" method="POST" class="space-y-4">
                    @csrf
                    <div class="grid sm:grid-cols-2 gap-4">
                        <div>
                            <label class="form-label">Your Name *</label>
                            <input type="text" name="name" value="{{ old('name') }}" required class="form-input" placeholder="John Doe">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="form-label">Email *</label>
                            <input type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="john@company.com">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Phone Number</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" class="form-input" placeholder="09137652910">
                    </div>
                    <div>
                        <label class="form-label">Subject *</label>
                        <input type="text" name="subject" value="{{ old('subject') }}" required class="form-input" placeholder="Bulk furniture order inquiry">
                        @error('subject')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label class="form-label">Message *</label>
                        <textarea name="message" rows="5" required class="form-input" placeholder="Tell us about your furniture needs...">{{ old('message') }}</textarea>
                        @error('message')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn-primary w-full justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        Send Message
                    </button>
                </form>
            </div>

            {{-- Contact Info --}}
            <div class="space-y-6">
                <div>
                    <h2 class="text-2xl font-bold mb-6" style="font-family: 'Calistoga', serif; color: var(--brand-dark);">Contact Information</h2>
                    <div class="space-y-5">
                        @foreach([
                            ['☎', 'Phone / WhatsApp', '09137652910', 'tel:09137652910'],
                            ['✉', 'Email', 'info@ziegofurniture.com', 'mailto:info@ziegofurniture.com'],
                            ['📍', 'Location', 'Nigeria — Nationwide Delivery', null],
                            ['🏢', 'RC Number', '9093335', null],
                        ] as [$icon, $label, $value, $link])
                        <div class="flex gap-4 p-4 rounded-xl border border-gray-100 bg-white card-hover">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 text-xl" style="background: var(--brand-pale);">{{ $icon }}</div>
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-0.5">{{ $label }}</div>
                                @if($link)
                                    <a href="{{ $link }}" class="font-semibold hover:underline" style="color: var(--brand-dark);">{{ $value }}</a>
                                @else
                                    <div class="font-semibold" style="color: var(--brand-dark);">{{ $value }}</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <div class="p-6 rounded-2xl" style="background: linear-gradient(135deg, var(--brand) 0%, var(--brand-dark) 100%);">
                    <h3 class="text-white font-bold text-lg mb-3">Quick WhatsApp Order</h3>
                    <p class="text-white/70 text-sm mb-4">Prefer to order via WhatsApp? Chat with us directly for bulk orders, wholesale inquiries, and custom furniture requests.</p>
                    <a href="https://wa.me/2349137652910" target="_blank" class="flex items-center gap-2 bg-green-500 hover:bg-green-600 transition-colors text-white font-semibold py-3 px-5 rounded-lg text-sm w-fit">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        Chat on WhatsApp
                    </a>
                </div>

                <div class="p-5 rounded-xl border border-gray-100 bg-white">
                    <h3 class="font-bold text-sm mb-3" style="color: var(--brand-dark);">Business Hours</h3>
                    <div class="space-y-2 text-sm">
                        <div class="flex justify-between"><span class="text-gray-500">Monday - Friday</span><span class="font-medium">8:00 AM - 6:00 PM</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Saturday</span><span class="font-medium">9:00 AM - 4:00 PM</span></div>
                        <div class="flex justify-between"><span class="text-gray-500">Sunday</span><span class="text-gray-400">Closed</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
