import PageHeading from "@/Pages/components/body/PageHeading.jsx";
import InfiniteScrolling from "@/Pages/components/forms/InfiniteScrolling.jsx";
import {Fragment} from "react";
import ReportCard from "@/Pages/components/cards/ReportCard.jsx";

const Index = ({ reports }) => {
    return (
        <>
            <PageHeading title={'Reports'} />

            {reports.data.length > 0 ? (
                <InfiniteScrolling data={'reports'}>
                    <div className="grid gap-8 lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-1 mb-2">

                        {reports.data.map((report) => (
                            <Fragment key={report.id}>
                                <ReportCard report={report}/>
                            </Fragment>
                        ))}
                    </div>
                </InfiniteScrolling>
                ) : (
                <p className="text-gray-500 font-semibold mt-10">No reports made yet.</p>
            )}
        </>
    )
}

export default Index;
