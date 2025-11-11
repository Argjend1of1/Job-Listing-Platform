const UserLogo = ({user, setIsOpen}) => {
    return (
        <img
            src={user?.logo ? `/storage/${user?.logo}` : 'storage/logos/default-logo.png'}
            alt="Employer Logo"
            className="cursor-pointer rounded-full w-8 h-8 "
            onClick={() => setIsOpen(prevState => !prevState)}
        />
    )
}

export default UserLogo;
