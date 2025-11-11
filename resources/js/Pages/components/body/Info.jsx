const Info = ({label, data}) => {
    return (
        <div>
            <p className="text-lg text-white font-semibold">{label}</p>
            <p className="text-gray-400 text-base">{data}</p>
        </div>
    )
}

export default Info;
