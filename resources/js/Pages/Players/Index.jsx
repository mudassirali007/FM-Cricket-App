import React from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head } from '@inertiajs/react';
import NavLink from "@/Components/NavLink.jsx";


export default function Players({ auth, players }) {

    return (
        <AuthenticatedLayout
            username={auth.username}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">Players List</h2>}
        >
            <Head title="Players List" />
            <div className="">
                <div className={`flex justify-end lg:px-8 max-w-7xl mx-auto sm:px-6`}>
                    <button type="button" className="m-2 bg-white inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                        <NavLink href={route('players.create')}>Create</NavLink>
                    </button>
                </div>
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div className="p-6">
                            <table className="min-w-full table-auto">
                                <thead className="bg-gray-100">
                                <tr>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Image
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Contact
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Team Name
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Age
                                    </th>
                                    <th className="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Action
                                    </th>
                                </tr>
                                </thead>
                                <tbody className="bg-white divide-y divide-gray-200">
                                {players.map((player, index) => (
                                    <tr key={index}>
                                        <td className="px-6 py-4 whitespace-nowrap">
                                             <img src={ player.image ? `/proxy?url=${player.image}` : '/images/no-image-placeholder.webp' } alt="Player" className="h-10 w-10 rounded-full"/>
                                            {/*<img src={ player.image_base64 ? player.image_base64 : '/images/no-image-placeholder.webp' } alt="Player" className="h-10 w-10 rounded-full"/>*/}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {player.name}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {player.contact}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {player.team_name}
                                        </td>
                                        <td className="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {player.age}
                                        </td>
                                        <td>
                                            <button className="px-4 py-2 bg-indigo-50 text-white rounded ">
                                                <NavLink href={route('players.show', player.id)}>View</NavLink>
                                            </button>
                                        </td>
                                    </tr>
                                ))}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}
