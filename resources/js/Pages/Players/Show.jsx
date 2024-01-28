import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';

export default function Show({ auth, player }) {
    return (
        <AuthenticatedLayout
            user={auth.user}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Player Details</h2>}
        >
            <Head title="Player Details" />

            <div className="py-12">
                <div className="max-w-4xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6 bg-white border-b border-gray-200">
                            <div className="flex flex-col items-center">
                                <img
                                    src={player.image || 'path/to/default/image.jpg'}
                                    alt="Player"
                                    className="w-32 h-32 rounded-full mb-4"
                                />
                                <h3 className="text-lg leading-6 font-medium text-gray-900">{player.name}</h3>
                                <p className="mt-1 text-sm text-gray-500">Age: {player.age}</p>
                                <p className="mt-1 text-sm text-gray-500">Contact: {player.contact}</p>
                                <p className="mt-1 text-sm text-gray-500">Team Name: {player.team_name}</p>
                                {/* Add more details if needed */}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
