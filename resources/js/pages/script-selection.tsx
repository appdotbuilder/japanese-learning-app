import React from 'react';
import { Link } from '@inertiajs/react';

export default function ScriptSelection() {
    return (
        <div className="min-h-screen bg-gradient-to-br from-rose-50 to-pink-100">
            {/* Header */}
            <header className="px-6 py-4">
                <div className="max-w-7xl mx-auto flex items-center">
                    <Link href="/" className="flex items-center space-x-2 hover:opacity-80 transition-opacity">
                        <span className="text-2xl">🌸</span>
                        <h1 className="text-xl font-bold text-gray-800">JapaneseLearn</h1>
                    </Link>
                </div>
            </header>

            <main className="max-w-4xl mx-auto px-6 py-12">
                {/* Back button */}
                <div className="mb-8">
                    <Link
                        href="/"
                        className="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors"
                    >
                        <span className="mr-2">←</span>
                        Kembali ke Home
                    </Link>
                </div>

                <div className="text-center mb-12">
                    <h2 className="text-4xl font-bold text-gray-800 mb-4">
                        Pilih Sistem Tulisan 📚
                    </h2>
                    <p className="text-xl text-gray-600">
                        Mulai belajar dengan memilih Hiragana atau Katakana
                    </p>
                </div>

                <div className="grid md:grid-cols-2 gap-8">
                    {/* Hiragana Card */}
                    <div className="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <div className="bg-blue-500 p-6 text-center">
                            <div className="text-6xl mb-4 text-white">ひ</div>
                            <h3 className="text-2xl font-bold text-white">Hiragana</h3>
                        </div>
                        
                        <div className="p-6">
                            <div className="text-center mb-6">
                                <div className="text-4xl space-x-2 mb-4">
                                    <span>あ</span>
                                    <span>か</span>
                                    <span>さ</span>
                                    <span>た</span>
                                </div>
                            </div>
                            
                            <p className="text-gray-600 mb-6 leading-relaxed">
                                Sistem tulisan Jepang yang digunakan untuk kata-kata asli Jepang. 
                                Hiragana adalah dasar yang penting untuk dipelajari terlebih dahulu.
                            </p>
                            
                            <div className="space-y-2 mb-6">
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-600">Tingkat Kesulitan:</span>
                                    <span className="text-blue-600 font-medium">Pemula</span>
                                </div>
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-600">Total Karakter:</span>
                                    <span className="text-blue-600 font-medium">20+ karakter</span>
                                </div>
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-600">Penggunaan:</span>
                                    <span className="text-blue-600 font-medium">Kata Jepang asli</span>
                                </div>
                            </div>
                            
                            <Link
                                href="/lessons/hiragana"
                                className="w-full bg-blue-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-blue-600 transition-colors text-center block"
                            >
                                Mulai Belajar Hiragana 🚀
                            </Link>
                        </div>
                    </div>

                    {/* Katakana Card */}
                    <div className="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                        <div className="bg-green-500 p-6 text-center">
                            <div className="text-6xl mb-4 text-white">カ</div>
                            <h3 className="text-2xl font-bold text-white">Katakana</h3>
                        </div>
                        
                        <div className="p-6">
                            <div className="text-center mb-6">
                                <div className="text-4xl space-x-2 mb-4">
                                    <span>ア</span>
                                    <span>カ</span>
                                    <span>サ</span>
                                    <span>タ</span>
                                </div>
                            </div>
                            
                            <p className="text-gray-600 mb-6 leading-relaxed">
                                Sistem tulisan untuk kata-kata asing dan nama tempat/orang asing. 
                                Katakana memiliki bentuk yang lebih angular dibanding Hiragana.
                            </p>
                            
                            <div className="space-y-2 mb-6">
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-600">Tingkat Kesulitan:</span>
                                    <span className="text-green-600 font-medium">Pemula</span>
                                </div>
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-600">Total Karakter:</span>
                                    <span className="text-green-600 font-medium">20+ karakter</span>
                                </div>
                                <div className="flex justify-between text-sm">
                                    <span className="text-gray-600">Penggunaan:</span>
                                    <span className="text-green-600 font-medium">Kata asing</span>
                                </div>
                            </div>
                            
                            <Link
                                href="/lessons/katakana"
                                className="w-full bg-green-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-green-600 transition-colors text-center block"
                            >
                                Mulai Belajar Katakana 🚀
                            </Link>
                        </div>
                    </div>
                </div>

                {/* Info Section */}
                <div className="mt-12 bg-white rounded-xl p-8 shadow-lg">
                    <h3 className="text-2xl font-bold text-gray-800 text-center mb-6">
                        💡 Tips Belajar
                    </h3>
                    
                    <div className="grid md:grid-cols-2 gap-8">
                        <div>
                            <h4 className="font-semibold text-gray-800 mb-3">📝 Mulai dengan Hiragana</h4>
                            <p className="text-gray-600">
                                Disarankan untuk memulai dengan Hiragana terlebih dahulu karena lebih fundamental 
                                dalam bahasa Jepang sehari-hari.
                            </p>
                        </div>
                        
                        <div>
                            <h4 className="font-semibold text-gray-800 mb-3">🎯 Konsistensi adalah Kunci</h4>
                            <p className="text-gray-600">
                                Luangkan waktu 15-30 menit setiap hari untuk berlatih. 
                                Konsistensi lebih penting daripada durasi belajar yang lama.
                            </p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    );
}