const Heading = ({title}) => {
    return (
        <div className="inline-flex items-center gap-x-2">
            <span className="w-2 h-2 bg-white inline-block rounded-xl"></span>
            <h3 className="font-bold text-lg">{title}</h3>
        </div>
    )
}

export default Heading;
