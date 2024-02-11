import React, { useState } from 'react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import { Head, useForm } from '@inertiajs/react';
import NavLink from "@/Components/NavLink.jsx";

export default function Show({ auth, player = {} }) {

    const isEditing = player?.id || null;

    const { data, setData, post, errors } = useForm({
        name: player?.name || '',
        age: player?.age || '',
        contact: player?.contact || '',
        team_name: player?.team_name || '',
        // image: player.image,
        _method: isEditing ? 'PUT' : 'POST'
    });
    // Local state for image preview
    const [imagePreview, setImagePreview] = useState(player?.image ? `/proxy?url=${player.image}` : '/images/no-image-placeholder.webp');

    // Adjusted handleSubmit remains the same...


    const handleImageChange = (e) => {
        const file = e.target.files[0];
        if (file) {
            setData('image', file); // Update the form data with the new image file
            setImagePreview(URL.createObjectURL(file)); // Create a preview URL
        }
    };

    const handleSubmit = (e) => {
        e.preventDefault();
        const url = isEditing ? route('players.update', player.id) : route('players.store');
        console.log(url,data,post)
        post(url, {
            forceFormData: true,
        });
    };

    return (
        <AuthenticatedLayout
            username={auth.username}
            header={<h2 className="font-semibold text-xl text-gray-800 leading-tight">{`${isEditing ? `Edit Player` : `Create Player`}`}</h2>}
        >
            <Head title={`${isEditing ? `Edit Player` : `Create Player`}`} />

            <form onSubmit={handleSubmit} className="space-y-4">
                <div className="py-6">
                    {isEditing ?
                    <>
                        <div className={`flex justify-end max-w-4xl mx-auto sm:px-6 lg:px-8`}>
                            <button type="button" className="m-2 bg-white inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                <NavLink href={route('players.create')}>Create</NavLink>
                            </button>
                        </div>
                    </> : ``
                    }
                    <div className="max-w-4xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <div className="p-6 bg-white border-b border-gray-200">
                                <div className="flex items-center">
                                    <div className="flex-1">
                                        <div>
                                            <label htmlFor="name" className="block text-sm font-medium text-gray-700">Name</label>
                                            <input
                                                id="name"
                                                name="name"
                                                type="text"
                                                value={data.name}
                                                onChange={(e) => setData('name', e.target.value)}
                                                className="mt-1 block w-full"
                                            />
                                        </div>
                                        <div>
                                            <label htmlFor="age" className="block text-sm font-medium text-gray-700">Age</label>
                                            <input
                                                id="age"
                                                name="age"
                                                type="number"
                                                value={data.age}
                                                onChange={(e) => setData('age', e.target.value)}
                                                className="mt-1 block w-full"
                                            />
                                        </div>
                                        <div>
                                            <label htmlFor="contact" className="block text-sm font-medium text-gray-700">Contact Number</label>
                                            <input
                                                id="contact"
                                                name="contact"
                                                type="text"
                                                value={data.contact}
                                                onChange={(e) => setData('contact', e.target.value)}
                                                className="mt-1 block w-full"
                                            />
                                        </div>
                                        <div>
                                            <label htmlFor="team_name" className="block text-sm font-medium text-gray-700">Team Name</label>
                                            <input
                                                id="team_name"
                                                name="team_name"
                                                type="text"
                                                value={data.team_name}
                                                onChange={(e) => setData('team_name', e.target.value)}
                                                className="mt-1 block w-full"
                                                readOnly
                                                disabled
                                            />
                                        </div>
                                        <div className={`py-2`}>
                                            <button type="submit" className="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                {isEditing ? `Update` : `Save`}
                                            </button>
                                            <button type="button" className="mx-6 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                                <NavLink className={`no-underline`} href={route('players.index')}>Back</NavLink>
                                            </button>
                                        </div>
                                    </div>
                                    <div className="flex-1 flex-col inline-flex items-center justify-center">
                                        <img
                                            src={imagePreview}
                                            alt="Player"
                                            className="object-contain h-auto w-48"
                                        />

                                        <label htmlFor="image"
                                               className="m-2 inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                            Upload New Image
                                            <input
                                                id="image"
                                                name="image"
                                                type="file"
                                                accept="image/*"
                                                onChange={handleImageChange}
                                                className="hidden" // Hide the actual input but show the label as a button
                                            />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </AuthenticatedLayout>
    );
}
