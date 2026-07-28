<footer class="bg-gray-900 text-gray-300 pt-12 pb-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">

            <!-- Brand -->
            <div>
                <h3 class="text-2xl font-bold text-white mb-3">திருமணம்</h3>
                <p class="text-sm text-gray-400">A trusted Tamil matrimonial platform connecting families across India.</p>
            </div>

            <!-- Quick Links -->
            <div>
                <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ url('/') }}" class="hover:text-white transition">Home</a></li>
                    <li><a href="{{ url('/members') }}" class="hover:text-white transition">Members</a></li>
                    <li><a href="{{ url('/plans') }}" class="hover:text-white transition">Plans</a></li>
                    <li><a href="{{ url('/contact') }}" class="hover:text-white transition">Contact</a></li>
                    <li><a href="{{ url('/faq') }}" class="hover:text-white transition">FAQ</a></li>
                    <li><a href="{{ url('/privacy-policy') }}" class="hover:text-white transition">Privacy Policy</a></li>
                    <li><a href="{{ url('/terms') }}" class="hover:text-white transition">Terms & Conditions</a></li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h4 class="text-white font-semibold mb-4">Contact Us</h4>
                <ul class="space-y-2 text-sm">
                    <li><i class="fas fa-phone-alt mr-2 text-primary"></i> (+91) 94878 33674</li>
                    <li><i class="fas fa-phone-alt mr-2 text-primary"></i> (+91) 98942 78185</li>
                    <li><i class="fas fa-envelope mr-2 text-primary"></i> service@thirumanam.info</li>
                </ul>
            </div>
        </div>

        <div class="border-t border-gray-700 pt-6 text-center text-sm text-gray-500">
            &copy; {{ date('Y') }} Thirumanam.info. All rights reserved.
        </div>
    </div>
</footer>
