import {Link, usePage} from '@inertiajs/react'
import logo from '../../../images/platform-logo.webp'
import {useEffect, useState} from "react";
import RoleBasedDisplay from "@/Pages/auth/RoleBasedDisplay.jsx";

export default function Layout({ children }) {
    const { categories, auth, flash } = usePage().props
    const [flashMessage, setFlashMessage] = useState(false)

    useEffect(() => {
        if(flash.success) {
            setFlashMessage(true)

            const timeout = setTimeout(() => {
                setFlashMessage(false)
            }, 2500)

            return () => clearTimeout(timeout);
        }
    }, [flash]);

    return (
            <div className="bg-black text-white font-hanken-grotesk px-10 min-h-screen pb-10">
                <nav className="flex justify-between items-center py-5 border-b border-white/10">
                    <div>
                        <Link href="/">
                            <img src={logo} alt="logo" width="45px" height="45px" className="rounded-full bg-transparent" />
                        </Link>
                    </div>

                    <div className="space-x-6 font-bold flex items-center">
                        <Link href="/jobs" className="hover:underline">Listings</Link>
                        <Link href={"/companies"} className="hover:underline">Companies</Link>

                        <div className="relative group inline-block">
                            <span className="hover:underline inline-block cursor-pointer">Categories</span>
                            <div className="absolute left-0 top-full opacity-0 invisible group-hover:opacity-100 group-hover:visible bg-black text-white shadow-lg rounded-md mt-2 z-10 w-max transition-opacity transition-transform duration-300 delay-100 ease-in-out transform group-hover:-translate-x-40">
                                <div className="grid grid-cols-2 sm:grid-cols-2 gap-3">
                                    {categories?.map((category) => (
                                        <Link
                                            key={category.id}
                                            href={`/categories/${category.name}`}
                                            className="text-xs block px-4 py-2 hover:bg-gray-800 rounded whitespace-nowrap transition-colors duration-150"
                                        >
                                            {category.name}
                                        </Link>
                                    ))}
                                </div>
                            </div>
                        </div>
                    </div>

                    {auth?.user ? (
                            <RoleBasedDisplay auth={auth} />
                    ) : (
                        <div className="space-x-6 font-bold">
                            <Link href={"/login"}>Login</Link>
                            <Link href={"/register"}>Register</Link>
                        </div>
                    )}
                </nav>

                {flashMessage && flash.success && (
                    <div className="fixed top-20 right-4 bg-green-600 text-white px-4 py-2 rounded">
                        {flash.success}
                    </div>
                )}

                <main className="mt-8 max-w-[986px] mx-auto">
                    {children}
                </main>
            </div>
    )
}
