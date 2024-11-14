import { NextPage } from 'next';
import { AdminLayout } from '@layout';
import React from 'react';
import { useRouter } from 'next/router';
import useGetProject from '../../../hooks/api/project/useGetProject';

const ProjectsView: NextPage = () => {
  const router = useRouter();
  const id = router.query.id as string;
  const { project } = useGetProject(id);

  return (
    <AdminLayout>
      { project !== undefined ? (
        <div>
          <div className="mb-3">
            <div>Title</div>
            <div>{project.title}</div>
          </div>
        </div>
      ) : 'loading' }
    </AdminLayout>
  );
};
export default ProjectsView;
