import React from 'react';
import { Link } from '@inertiajs/react';

export default function Welcome() {
    return (
        <div className="min-h-screen bg-gradient-to-br from-rose-50 to-pink-100">
            {/* Header */}
            <header className="px-6 py-4">
                <div className="max-w-7xl mx-auto flex items-center justify-between">
                    <div className="flex items-center space-x-2">
                        <span className="text-2xl">🌸</span>
                        <h1 className="text-xl font-bold text-gray-800">JapaneseLearn</h1>
                    </div>
                    <nav className="flex items-center space-x-4">
                        <Link
                            href="/login"
                            className="text-gray-600 hover:text-gray-800 transition-colors"
                        >
                            Login
                        </Link>
                        <Link
                            href="/register"
                            className="bg-pink-500 text-white px-4 py-2 rounded-lg hover:bg-pink-600 transition-colors"
                        >
                            Register
                        </Link>
                    </nav>
                </div>
            </header>

            {/* Hero Section */}
            <main className="max-w-7xl mx-auto px-6 py-12">
                <div className="text-center mb-16">
                    <div className="mb-8">
                        <span className="text-8xl">🏯</span>
                    </div>
                    <h2 className="text-5xl font-bold text-gray-800 mb-6">
                        Belajar Bahasa Jepang
                        <span className="block text-pink-500 mt-2">dengan Mudah!</span>
                    </h2>
                    <p className="text-xl text-gray-600 max-w-3xl mx-auto mb-12">
                        Pelajari Hiragana dan Katakana dengan sistem flashcard interaktif. 
                        Mulai perjalanan bahasa Jepang Anda hari ini!
                    </p>
                    
                    <Link
                        href="/scripts"
                        className="inline-flex items-center bg-pink-500 text-white text-xl font-semibold px-8 py-4 rounded-xl hover:bg-pink-600 transition-colors shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                    >
                        🚀 Mulai Belajar Gratis
                    </Link>
                </div>

                {/* Features Section */}
                <div className="grid md:grid-cols-3 gap-8 mb-16">
                    <div className="bg-white rounded-xl p-6 shadow-lg text-center">
                        <div className="text-4xl mb-4">📝</div>
                        <h3 className="text-xl font-semibold text-gray-800 mb-3">Hiragana & Katakana</h3>
                        <p className="text-gray-600">
                            Pelajari kedua sistem tulisan Jepang dasar dengan metode yang mudah dipahami
                        </p>
                    </div>
                    
                    <div className="bg-white rounded-xl p-6 shadow-lg text-center">
                        <div className="text-4xl mb-4">🎯</div>
                        <h3 className="text-xl font-semibold text-gray-800 mb-3">Sistem Flashcard</h3>
                        <p className="text-gray-600">
                            Metode pembelajaran interaktif dengan flashcard yang membantu mengingat lebih cepat
                        </p>
                    </div>
                    
                    <div className="bg-white rounded-xl p-6 shadow-lg text-center">
                        <div className="text-4xl mb-4">📊</div>
                        <h3 className="text-xl font-semibold text-gray-800 mb-3">Progress Tracking</h3>
                        <p className="text-gray-600">
                            Pantau kemajuan belajar Anda dengan sistem progress yang jelas dan terukur
                        </p>
                    </div>
                </div>

                {/* Preview Section */}
                <div className="bg-white rounded-xl p-8 shadow-lg">
                    <h3 className="text-2xl font-bold text-gray-800 text-center mb-8">
                        🎌 Apa yang Akan Anda Pelajari?
                    </h3>
                    
                    <div className="grid md:grid-cols-2 gap-8">
                        <div className="text-center">
                            <div className="bg-blue-50 rounded-lg p-6 mb-4">
                                <h4 className="text-xl font-semibold text-blue-800 mb-4">Hiragana</h4>
                                <div className="text-4xl space-x-4">
                                    <span>あ</span>
                                    <span>い</span>
                                    <span>う</span>
                                    <span>え</span>
                                    <span>お</span>
                                </div>
                                <p className="text-blue-600 mt-3">Sistem tulisan untuk kata-kata Jepang asli</p>
                            </div>
                        </div>
                        
                        <div className="text-center">
                            <div className="bg-green-50 rounded-lg p-6 mb-4">
                                <h4 className="text-xl font-semibold text-green-800 mb-4">Katakana</h4>
                                <div className="text-4xl space-x-4">
                                    <span>ア</span>
                                    <span>イ</span>
                                    <span>ウ</span>
                                    <span>エ</span>
                                    <span>オ</span>
                                </div>
                                <p className="text-green-600 mt-3">Sistem tulisan untuk kata-kata asing</p>
                            </div>
                        </div>
                    </div>
                </div>

                {/* CTA Section */}
                <div className="text-center mt-16">
                    <h3 className="text-2xl font-bold text-gray-800 mb-6">
                        Siap Memulai Petualangan Bahasa Jepang Anda?
                    </h3>
                    <Link
                        href="/scripts"
                        className="inline-flex items-center bg-gradient-to-r from-pink-500 to-red-500 text-white text-xl font-semibold px-10 py-4 rounded-xl hover:from-pink-600 hover:to-red-600 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1"
                    >
                        🌟 Mulai Sekarang
                    </Link>
                </div>
            </main>

            {/* Footer */}
            <footer className="bg-gray-800 text-white py-8 mt-16">
                <div className="max-w-7xl mx-auto px-6 text-center">
                    <p>&copy; 2024 JapaneseLearn. Belajar bahasa Jepang dengan mudah dan menyenangkan!</p>
                </div>
            </footer>
        </div>
    );
}