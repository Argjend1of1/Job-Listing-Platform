import {useForm} from "@inertiajs/react";
import {useEffect, useRef, useState} from "react";
import DropdownRoute from "@/Pages/auth/DropdownRoute.jsx";

const RoleBasedDisplay = ({auth}) => {
    const {user} = auth;
    const {delete:destroy} = useForm();

    const [isOpen, setIsOpen] = useState(false);

    const dropdownRef = useRef(null);
    const dropdownButtonsRef = useRef(null)
    const timeoutRef = useRef(null);
    // Because useRef() returns an object like this:
    // { current: null }, you can store anything in .current — not just
    // DOM nodes. Think of useRef() as a persistent variable that lives
    // as long as the component is mounted.

    useEffect(() => {
        const handleClick = (e) => {
            if(!dropdownRef.current.contains(e.target)) {
                setIsOpen(false);
            }
            if(dropdownButtonsRef.current?.contains(e.target)) {
                timeoutRef.current = setTimeout(() => {
                    setIsOpen(prevState => !prevState);
                }, 300)
            }
        }
        document.addEventListener('mousedown', handleClick)

        return () => {
            document.removeEventListener('mousedown', handleClick)
            if(timeoutRef.current) {
                clearTimeout(timeoutRef.current)
            }
        }

    }, []);

    const handleLogOut = (e) => {
        e.preventDefault();
        destroy('/logout');
    }

    return (
        <div className="relative" ref={dropdownRef}>
            <div>
                <img src={user.logo}
                     alt={user.name}
                     className="rounded-full flex items-center justify-center"
                     width="40"
                     height="40"
                />
            </div>

            {isOpen && (
                <div
                    className="absolute bg-black border-1 border-gray-800 right-0 mt-2 w-48 rounded-md shadow-lg z-50 transition-all duration-200 ease-out transform scale-95"
                    ref={dropdownButtonsRef}
                >
                    {user.role === 'user' && (
                        <>
                            <DropdownRoute href={"/account"} >
                                Account
                            </DropdownRoute>

                            <DropdownRoute href={'/resume'}>
                                Upload Resume
                            </DropdownRoute>

                            <DropdownRoute href={"/bookmarks"}>
                                Bookmarks
                            </DropdownRoute>
                        </>
                    )}

                    {(user.role === 'employer' || user.role === 'superemployer') && (
                        <>
                            <DropdownRoute href={"/account"} >
                                Account
                            </DropdownRoute>

                            <DropdownRoute href={'/dashboard'} >
                                Dashboard
                            </DropdownRoute>

                            <DropdownRoute href={"/jobs/create"}>
                                Post a Job
                            </DropdownRoute>
                        </>
                    )}



                    {user.role === 'admin' && (
                        <>
                            <DropdownRoute href={"/account"} >
                                Account
                            </DropdownRoute>

                            <DropdownRoute href={'/employers'} >
                                Employers
                            </DropdownRoute>

                            <DropdownRoute href={"/premiumEmployers"}>
                                Premium Employers
                            </DropdownRoute>

                            <DropdownRoute href={"/reports"}>
                                Reported Jobs
                            </DropdownRoute>
                        </>
                    )}

                    {user.role === 'superadmin' && (
                        <>
                            <DropdownRoute href={"/admins"}>
                                Admins
                            </DropdownRoute>

                            <DropdownRoute href={'/employers'}>
                                Employers
                            </DropdownRoute>

                            <DropdownRoute href={"/premiumEmployers"}>
                                Premium Employers
                            </DropdownRoute>

                            <DropdownRoute href={"/admins/create"}>
                                Promote Users
                            </DropdownRoute>

                            <DropdownRoute href={"/reports"}>
                                Reported Jobs
                            </DropdownRoute>
                        </>
                    )}

                    {isOpen && (
                        <button
                            id="logoutBtn"
                            className="w-full text-left block px-4 py-2 text-red-400 hover:bg-red-900 cursor-pointer focus:bg-red-950"
                            onClick={handleLogOut}
                        >
                            Log Out
                        </button>
                    )}
                </div>
            )}
        </div>
    )
}

export default RoleBasedDisplay;
