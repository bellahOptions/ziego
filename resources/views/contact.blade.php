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
                        <div class="flex gap-4 p-4 rounded-xl border border-gray-100 bg-white card-hover">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--brand-pale);">
                                <svg class="w-5 h-5" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            </div>
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-0.5">Phone / WhatsApp</div>
                                <a href="tel:09137652910" class="font-semibold hover:underline" style="color: var(--brand-dark);">09137652910</a>
                            </div>
                        </div>
                        <div class="flex gap-4 p-4 rounded-xl border border-gray-100 bg-white card-hover">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--brand-pale);">
                                <svg class="w-5 h-5" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-0.5">Email</div>
                                <a href="mailto:info@ziegofurniture.com" class="font-semibold hover:underline" style="color: var(--brand-dark);">info@ziegofurniture.com</a>
                            </div>
                        </div>
                        <div class="flex gap-4 p-4 rounded-xl border border-gray-100 bg-white card-hover">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--brand-pale);">
                                <svg class="w-5 h-5" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-0.5">Location</div>
                                <div class="font-semibold" style="color: var(--brand-dark);">Nigeria — Nationwide Delivery</div>
                            </div>
                        </div>
                        <div class="flex gap-4 p-4 rounded-xl border border-gray-100 bg-white card-hover">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0" style="background: var(--brand-pale);">
                                <svg class="w-5 h-5" style="color: var(--brand);" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                            </div>
                            <div>
                                <div class="text-xs font-semibold uppercase tracking-wider text-gray-400 mb-0.5">RC Number</div>
                                <div class="font-semibold" style="color: var(--brand-dark);">9093335</div>
                            </div>
                        </div>
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
