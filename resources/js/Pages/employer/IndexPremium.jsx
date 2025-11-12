import Employers from "@/Pages/components/Employers.jsx";

const IndexPremium = ({ employers, query }) => {
    return <Employers
                employers={employers}
                query={query}
                endpoint={'/premiumEmployers'}
                title={'Premium Employers'}
            />
}

export default IndexPremium;
