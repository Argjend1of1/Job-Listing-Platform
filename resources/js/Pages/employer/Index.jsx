import Employers from "@/Pages/components/Employers.jsx";

const Index = ({employers, query}) => {
    return <Employers
                employers={employers}
                query={query}
                endpoint={'/employers'}
                reset={'employers'}
                title={'Employers'}
            />
}

export default Index;
