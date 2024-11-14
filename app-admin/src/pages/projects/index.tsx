import { NextPage } from 'next';
import { AdminLayout } from '@layout';
import { Table } from 'react-bootstrap';
import React from 'react';
import Link from 'next/link';
import { useRouter } from 'next/router';
import useDeleteProject from '../../hooks/api/project/useDeleteProject';
import useListProjects from '../../hooks/api/project/useListProjects';

const ProjectsList: NextPage = () => {
  const router = useRouter();
  const { projects, loading } = useListProjects();

  const { deleteProject } = useDeleteProject();

  const handleDelete = async (id: string) => {
    const { data: error } = await deleteProject(id);

    if (!error) {
      await router.reload();
    }
  };

  return (
    <AdminLayout>
      { loading ? ('loading') : (
        <Table bordered hover striped>
          <thead className="bg-light">
            <tr>
              <th>#</th>
              <th>Name</th>
              <th aria-label="Action" />
            </tr>
          </thead>
          <tbody>
            {projects.map((project) => (
              <tr key={`project-${project.id}`}>
                <td>{project.id}</td>
                <td>{project.title}</td>
                <td>
                  <Link href={`/projects/${project.id}/view`}>View</Link>
                  &nbsp;-&nbsp;
                  <Link href={`/projects/${project.id}/edit`}>Edit</Link>
                  &nbsp;-&nbsp;
                  <a href="" onClick={() => handleDelete(project.id)}>Delete</a>
                </td>
              </tr>
            ))}
          </tbody>
        </Table>
      )}
    </AdminLayout>
  );
};
export default ProjectsList;
