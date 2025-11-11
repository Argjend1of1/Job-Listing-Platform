const Button = ({children, type, disabled, className = '', onClick}) => {

    return (
        <button
            className={className === '' ? 'block bg-blue-700 rounded py-2 px-6 font-bold hover:bg-blue-600 cursor-pointer focus:bg-blue-900' : className}
            disabled={disabled}
            type={type}
            onClick={onClick ?? null}
        >
            {children}
        </button>
    )

}

export default Button
