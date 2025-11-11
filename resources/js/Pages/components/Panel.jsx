const Panel = ({children, className = ''}) => {
    const defaultClasses =
        'p-4 bg-white/10 rounded-xl mt-3 flex border border-transparent hover:border-blue-900 cursor-pointer group transition-colors duration-200 min-w-[300px]';


    return (
        <div
            className={`${defaultClasses} ${className}`}
        >
            {children}
        </div>
    )
}

export default Panel;
