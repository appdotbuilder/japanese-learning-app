import React from 'react';
import { Link } from '@inertiajs/react';

interface Material {
    id: number;
    script_type: string;
    lesson_key: string;
    lesson_name: string;
    description: string;
    characters: Array<{
        jp: string;
        romaji: string;
        sound: string;
    }>;
}

interface Props {
    scriptType: string;
    materials: Material[];
    [key: string]: unknown;
}

export default function LessonSelection({ scriptType, materials }: Props) {
    const scriptInfo = {
        hiragana: {
            title: 'Hiragana',
            color: 'blue',
            emoji: 'ひ'
        },
        katakana: {
            title: 'Katakana',
            color: 'green',
            emoji: 'カ'
        }
    };

    const currentScript = scriptInfo[scriptType as keyof typeof scriptInfo];

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

            <main className="max-w-6xl mx-auto px-6 py-12">
                {/* Back button */}
                <div className="mb-8">
                    <Link
                        href="/scripts"
                        className="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors"
                    >
                        <span className="mr-2">←</span>
                        Kembali ke Pilihan Script
                    </Link>
                </div>

                <div className="text-center mb-12">
                    <div className="text-6xl mb-4">{currentScript.emoji}</div>
                    <h2 className="text-4xl font-bold text-gray-800 mb-4">
                        Materi {currentScript.title}
                    </h2>
                    <p className="text-xl text-gray-600">
                        Pilih materi yang ingin dipelajari
                    </p>
                </div>

                <div className="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {materials.map((material) => (
                        <div key={material.id} className="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition-shadow">
                            <div className={`bg-${currentScript.color}-500 p-4 text-center`}>
                                <div className="text-3xl text-white mb-2">
                                    {material.characters.slice(0, 3).map((char, index) => (
                                        <span key={index} className="mx-1">{char.jp}</span>
                                    ))}
                                </div>
                            </div>
                            
                            <div className="p-6">
                                <h3 className="text-xl font-bold text-gray-800 mb-3">
                                    {material.lesson_name}
                                </h3>
                                
                                <p className="text-gray-600 mb-4 leading-relaxed">
                                    {material.description}
                                </p>
                                
                                <div className="space-y-2 mb-6">
                                    <div className="flex justify-between text-sm">
                                        <span className="text-gray-600">Jumlah Karakter:</span>
                                        <span className={`text-${currentScript.color}-600 font-medium`}>
                                            {material.characters.length}
                                        </span>
                                    </div>
                                    <div className="flex justify-between text-sm">
                                        <span className="text-gray-600">Contoh:</span>
                                        <span className={`text-${currentScript.color}-600 font-medium`}>
                                            {material.characters.slice(0, 2).map(char => char.romaji).join(', ')}
                                        </span>
                                    </div>
                                </div>

                                {/* Preview characters */}
                                <div className="mb-6 p-3 bg-gray-50 rounded-lg">
                                    <div className="text-center">
                                        <div className="text-2xl space-x-3 mb-2">
                                            {material.characters.map((char, index) => (
                                                <span key={index}>{char.jp}</span>
                                            ))}
                                        </div>
                                        <div className="text-sm text-gray-600">
                                            {material.characters.map((char, index) => (
                                                <span key={index} className="mx-1">{char.romaji}</span>
                                            ))}
                                        </div>
                                    </div>
                                </div>
                                
                                <Link
                                    href={`/flashcard/${scriptType}/${material.lesson_key}`}
                                    className={`w-full bg-${currentScript.color}-500 text-white py-3 px-6 rounded-lg font-semibold hover:bg-${currentScript.color}-600 transition-colors text-center block`}
                                >
                                    Mulai Belajar 🎯
                                </Link>
                            </div>
                        </div>
                    ))}
                </div>

                {/* Learning Tips */}
                <div className="mt-12 bg-white rounded-xl p-8 shadow-lg">
                    <h3 className="text-2xl font-bold text-gray-800 text-center mb-6">
                        📚 Tips Pembelajaran
                    </h3>
                    
                    <div className="grid md:grid-cols-3 gap-6">
                        <div className="text-center">
                            <div className="text-3xl mb-3">🎯</div>
                            <h4 className="font-semibold text-gray-800 mb-2">Fokus pada Satu Materi</h4>
                            <p className="text-gray-600 text-sm">
                                Selesaikan satu materi sebelum lanjut ke materi berikutnya
                            </p>
                        </div>
                        
                        <div className="text-center">
                            <div className="text-3xl mb-3">🔄</div>
                            <h4 className="font-semibold text-gray-800 mb-2">Ulangi Secara Rutin</h4>
                            <p className="text-gray-600 text-sm">
                                Kembali ke materi yang sudah dipelajari untuk memperkuat ingatan
                            </p>
                        </div>
                        
                        <div className="text-center">
                            <div className="text-3xl mb-3">✍️</div>
                            <h4 className="font-semibold text-gray-800 mb-2">Latihan Menulis</h4>
                            <p className="text-gray-600 text-sm">
                                Cobalah menulis karakter yang sudah dipelajari di kertas
                            </p>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    );
}