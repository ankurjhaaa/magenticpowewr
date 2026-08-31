@extends('layouts.public')

@section('title', 'Contact Us — Magnatic EV')
@section('meta_description', 'Get in touch with Magnatic EV. Inquire about battery products, dealership opportunities, or technical support.')

@section('content')

    {{-- HERO --}}
    <section class="h-[60vh] w-full bg-black relative flex items-center justify-center overflow-hidden border-b border-white/5 pt-20">
        <div class="absolute inset-0 flex items-center justify-center z-0 opacity-5 pointer-events-none select-none">
            <h1 class="text-[25vw] font-black text-white whitespace-nowrap">CONTACT</h1>
        </div>
        
        <div class="relative z-10 text-center px-6 fade-up">
            <h2 class="text-4xl md:text-6xl font-black text-white tracking-tighter uppercase mb-6">Let's Talk<br>Power.</h2>
            <p class="text-white/40 text-sm md:text-base max-w-lg mx-auto leading-relaxed">
                Whether you need a custom battery solution, want to become a dealer, or require technical support, our team is ready to assist.
            </p>
        </div>
    </section>

    {{-- CONTACT FORM & INFO --}}
    <section class="bg-black py-24 md:py-32 border-b border-white/5">
        <div class="max-w-7xl mx-auto px-6 lg:px-12 flex flex-col md:flex-row gap-16 md:gap-24">
            
            {{-- Form --}}
            <div class="flex-1 w-full fade-up">
                <h3 class="text-2xl font-black text-white uppercase mb-8 tracking-tighter">Send an Inquiry</h3>
                
                @if(session('success'))
                    <div class="bg-brand-500/10 border border-brand-500/20 text-brand-500 p-4 mb-8 text-sm font-medium">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="#" method="POST" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-white/50 mb-2">Full Name</label>
                            <input type="text" name="name" required class="w-full bg-white/[0.02] border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-colors rounded-none">
                        </div>
                        <div>
                            <label class="block text-[10px] uppercase tracking-widest text-white/50 mb-2">Phone Number</label>
                            <input type="text" name="phone" required class="w-full bg-white/[0.02] border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-colors rounded-none">
                        </div>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-white/50 mb-2">Email Address</label>
                        <input type="email" name="email" class="w-full bg-white/[0.02] border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-colors rounded-none">
                    </div>

                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-white/50 mb-2">Subject</label>
                        <select name="subject" class="w-full bg-white/[0.02] border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-colors rounded-none appearance-none">
                            <option value="sales" class="bg-black text-white">Sales & Quotation</option>
                            <option value="dealership" class="bg-black text-white">Dealership Inquiry</option>
                            <option value="support" class="bg-black text-white">Technical Support</option>
                            <option value="other" class="bg-black text-white">Other</option>
                        </select>
                    </div>
                    
                    <div>
                        <label class="block text-[10px] uppercase tracking-widest text-white/50 mb-2">Message</label>
                        <textarea name="message" rows="5" required class="w-full bg-white/[0.02] border border-white/10 px-4 py-3 text-white focus:outline-none focus:border-brand-500 transition-colors rounded-none resize-none"></textarea>
                    </div>

                    <button type="submit" class="w-full md:w-auto bg-brand-500 text-black px-12 py-4 text-[10px] font-bold uppercase tracking-[0.3em] hover:bg-brand-400 transition-colors duration-300 rounded-none">
                        Submit Inquiry
                    </button>
                </form>
            </div>

            {{-- Info --}}
            <div class="w-full md:w-1/3 flex flex-col gap-12 fade-up">
                <div>
                    <h4 class="text-[10px] uppercase tracking-widest text-brand-500 font-bold mb-4">Headquarters</h4>
                    <p class="text-white/60 text-sm leading-relaxed mb-1">Magnatic EV Pvt. Ltd.</p>
                    <p class="text-white/60 text-sm leading-relaxed mb-1">Industrial Area, Sector 62</p>
                    <p class="text-white/60 text-sm leading-relaxed">Noida, UP 201309, India</p>
                </div>
                
                <div>
                    <h4 class="text-[10px] uppercase tracking-widest text-brand-500 font-bold mb-4">Contact Lines</h4>
                    <p class="text-white/60 text-sm leading-relaxed mb-1"><span class="text-white/40 mr-2">Sales:</span> +91 98765 43210</p>
                    <p class="text-white/60 text-sm leading-relaxed mb-1"><span class="text-white/40 mr-2">Support:</span> +91 91234 56789</p>
                    <p class="text-white/60 text-sm leading-relaxed"><span class="text-white/40 mr-2">Email:</span> info@magnaticev.com</p>
                </div>

                <div>
                    <h4 class="text-[10px] uppercase tracking-widest text-brand-500 font-bold mb-4">Business Hours</h4>
                    <p class="text-white/60 text-sm leading-relaxed mb-1">Monday - Saturday</p>
                    <p class="text-white/60 text-sm leading-relaxed">9:00 AM - 6:00 PM (IST)</p>
                </div>
            </div>

        </div>
    </section>

@endsection
