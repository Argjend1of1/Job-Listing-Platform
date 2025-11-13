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
        const handleClickOutside = (e) => {
            if (dropdownRef.current && !dropdownRef.current.contains(e.target)) {
                setIsOpen(false);
            }
        };
        const handleClickOnDropDown = (e) => {
            if(dropdownButtonsRef.current && dropdownButtonsRef.current.contains(e.target)) {
                timeoutRef.current = setTimeout(() => {
                    setIsOpen(false)
                }, 300)
            }
        }
        document.addEventListener('mousedown', handleClickOutside);
        document.addEventListener('mousedown', handleClickOnDropDown);

        return () => {
            document.removeEventListener('mousedown', handleClickOutside)
            document.removeEventListener('mousedown', handleClickOnDropDown)
            clearTimeout(timeoutRef.current)
        };

    }, []);

    const handleLogOut = (e) => {
        e.preventDefault();
        destroy('/logout');
    }

    return (
        <div className="relative" ref={dropdownRef}>
            <div className={'cursor-pointer'}
                 onClick={() => setIsOpen(prev => !prev)}
            >
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
                            <DropdownRoute href={"/account"} label={'Account'} />
                            <DropdownRoute href={"/resume"} label={'Upload Resume'} />
                            <DropdownRoute href={"/bookmarks"} label={'Bookmarks'} />
                        </>
                    )}

                    {(user.role === 'employer' || user.role === 'superemployer') && (
                        <>
                            <DropdownRoute href={"/account"} label={'Account'} />
                            <DropdownRoute href={"/dashboard"} label={'Dashboard'} />
                            <DropdownRoute href={"/jobs/create"} label={'Post a Job'} />
                        </>
                    )}

                    {user.role === 'admin' && (
                        <>
                            <DropdownRoute href={"/account"} label={'Account'} />
                            <DropdownRoute href={"/employers"} label={'Employers'} />
                            <DropdownRoute href={"/premiumEmployers"} label={'Premium Employers'} />
                            <DropdownRoute href={"/reports"} label={'Reported Jobs'} />
                        </>
                    )}

                    {user.role === 'superadmin' && (
                        <>
                            <DropdownRoute href={"/admins"} label={'Admins'} />
                            <DropdownRoute href={"/employers"} label={'Employers'} />
                            <DropdownRoute href={"/premiumEmployers"} label={'Premium Employers'} />
                            <DropdownRoute href={"/admins/create"} label={'Promote Users'} />
                            <DropdownRoute href={"/reports"} label={'Reported Jobs'} />
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
