import React, { useState } from 'react';
import { Link } from '@inertiajs/react';

interface Character {
    jp: string;
    romaji: string;
    sound: string;
}

interface Material {
    id: number;
    script_type: string;
    lesson_key: string;
    lesson_name: string;
    description: string;
    characters: Character[];
}

interface Props {
    scriptType: string;
    material: Material;
    [key: string]: unknown;
}

export default function Flashcard({ scriptType, material }: Props) {
    const [currentIndex, setCurrentIndex] = useState(0);
    const [showAnswer, setShowAnswer] = useState(false);
    
    const currentChar = material.characters[currentIndex];
    const progress = ((currentIndex + 1) / material.characters.length) * 100;

    const nextCard = () => {
        if (currentIndex < material.characters.length - 1) {
            setCurrentIndex(currentIndex + 1);
            setShowAnswer(false);
        }
    };

    const prevCard = () => {
        if (currentIndex > 0) {
            setCurrentIndex(currentIndex - 1);
            setShowAnswer(false);
        }
    };

    const goToCard = (index: number) => {
        setCurrentIndex(index);
        setShowAnswer(false);
    };

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
                <div className="max-w-7xl mx-auto flex items-center justify-between">
                    <Link href="/" className="flex items-center space-x-2 hover:opacity-80 transition-opacity">
                        <span className="text-2xl">🌸</span>
                        <h1 className="text-xl font-bold text-gray-800">JapaneseLearn</h1>
                    </Link>
                    
                    <div className="text-center">
                        <h2 className="text-lg font-semibold text-gray-800">
                            {material.lesson_name}
                        </h2>
                        <p className="text-sm text-gray-600">
                            {currentIndex + 1} / {material.characters.length}
                        </p>
                    </div>
                    
                    <div className="w-24"></div>
                </div>
            </header>

            <main className="max-w-4xl mx-auto px-6 py-8">
                {/* Back button */}
                <div className="mb-8">
                    <Link
                        href={`/lessons/${scriptType}`}
                        className="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors"
                    >
                        <span className="mr-2">←</span>
                        Kembali ke Daftar Materi
                    </Link>
                </div>

                {/* Progress Bar */}
                <div className="mb-8">
                    <div className="flex items-center justify-between mb-2">
                        <span className="text-sm text-gray-600">Progress</span>
                        <span className="text-sm text-gray-600">{Math.round(progress)}%</span>
                    </div>
                    <div className="w-full bg-gray-200 rounded-full h-2">
                        <div 
                            className={`bg-${currentScript.color}-500 h-2 rounded-full transition-all duration-300`}
                            style={{ width: `${progress}%` }}
                        ></div>
                    </div>
                </div>

                {/* Main Flashcard */}
                <div className="text-center mb-8">
                    <div 
                        className="bg-white rounded-2xl shadow-xl p-12 mx-auto max-w-md cursor-pointer hover:shadow-2xl transition-shadow"
                        onClick={() => setShowAnswer(!showAnswer)}
                    >
                        {!showAnswer ? (
                            <div>
                                <div className="text-8xl mb-6 text-gray-800">
                                    {currentChar.jp}
                                </div>
                                <p className="text-gray-500 text-lg">
                                    Klik untuk melihat jawaban
                                </p>
                            </div>
                        ) : (
                            <div>
                                <div className="text-6xl mb-4 text-gray-800">
                                    {currentChar.jp}
                                </div>
                                <div className="text-3xl font-bold text-pink-600 mb-2">
                                    {currentChar.romaji}
                                </div>
                                <div className="text-xl text-gray-600">
                                    [{currentChar.sound}]
                                </div>
                            </div>
                        )}
                    </div>
                </div>

                {/* Navigation Buttons */}
                <div className="flex justify-center space-x-4 mb-12">
                    <button
                        onClick={prevCard}
                        disabled={currentIndex === 0}
                        className={`px-6 py-3 rounded-lg font-semibold transition-colors ${
                            currentIndex === 0 
                                ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                : `bg-${currentScript.color}-500 text-white hover:bg-${currentScript.color}-600`
                        }`}
                    >
                        ← Sebelumnya
                    </button>
                    
                    <button
                        onClick={() => setShowAnswer(!showAnswer)}
                        className="px-6 py-3 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition-colors"
                    >
                        {showAnswer ? 'Sembunyikan' : 'Tampilkan'} Jawaban
                    </button>
                    
                    <button
                        onClick={nextCard}
                        disabled={currentIndex === material.characters.length - 1}
                        className={`px-6 py-3 rounded-lg font-semibold transition-colors ${
                            currentIndex === material.characters.length - 1
                                ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                : `bg-${currentScript.color}-500 text-white hover:bg-${currentScript.color}-600`
                        }`}
                    >
                        Selanjutnya →
                    </button>
                </div>

                {/* Character Grid Navigation */}
                <div className="bg-white rounded-xl p-6 shadow-lg">
                    <h3 className="text-lg font-semibold text-gray-800 mb-4 text-center">
                        Navigasi Cepat
                    </h3>
                    
                    <div className="grid grid-cols-5 gap-3">
                        {material.characters.map((char, index) => (
                            <button
                                key={index}
                                onClick={() => goToCard(index)}
                                className={`p-3 rounded-lg text-xl font-semibold transition-colors ${
                                    index === currentIndex
                                        ? `bg-${currentScript.color}-500 text-white`
                                        : 'bg-gray-100 text-gray-800 hover:bg-gray-200'
                                }`}
                            >
                                {char.jp}
                            </button>
                        ))}
                    </div>
                    
                    <div className="grid grid-cols-5 gap-3 mt-2">
                        {material.characters.map((char, index) => (
                            <div
                                key={index}
                                className={`p-1 text-center text-sm ${
                                    index === currentIndex
                                        ? `text-${currentScript.color}-600 font-semibold`
                                        : 'text-gray-500'
                                }`}
                            >
                                {char.romaji}
                            </div>
                        ))}
                    </div>
                </div>

                {/* Study Tips */}
                <div className="mt-8 bg-white rounded-xl p-6 shadow-lg">
                    <h3 className="text-lg font-semibold text-gray-800 mb-4 text-center">
                        💡 Tips Belajar
                    </h3>
                    
                    <div className="grid md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div>
                            <strong>🎯 Fokus:</strong> Perhatikan bentuk dan goresan setiap karakter
                        </div>
                        <div>
                            <strong>🔄 Repetisi:</strong> Ulangi karakter yang sulit beberapa kali
                        </div>
                        <div>
                            <strong>✍️ Tulis:</strong> Cobalah menulis karakter di udara atau kertas
                        </div>
                        <div>
                            <strong>🗣️ Ucapkan:</strong> Ucapkan bunyi karakter dengan keras
                        </div>
                    </div>
                </div>
            </main>
        </div>
    );
}