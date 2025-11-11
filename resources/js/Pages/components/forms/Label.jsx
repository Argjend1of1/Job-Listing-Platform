const Label = ({name, label}) => {
    return (
        <div className="inline-flex items-center gap-x-2 my-2">
            <span className="w-2 h-2 rounded-xl bg-white inline-block"></span>
            <label className="font-bold" htmlFor={`${name}`}>{label}</label>
        </div>
    )
}

export default Label
