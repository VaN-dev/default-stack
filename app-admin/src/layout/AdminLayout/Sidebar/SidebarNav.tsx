import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import {
  IconDefinition,
} from '@fortawesome/free-regular-svg-icons';
import {
  faPlus,
  faGauge,
  faList,
} from '@fortawesome/free-solid-svg-icons';
import React, {
  PropsWithChildren,
} from 'react';
import {
  Badge, Nav,
} from 'react-bootstrap';
import Link from 'next/link';

type SidebarNavItemProps = {
  href: string;
  icon?: IconDefinition;
} & PropsWithChildren;

const SidebarNavItem = (props: SidebarNavItemProps) => {
  const {
    icon,
    children,
    href,
  } = props;

  return (
    <Nav.Item>
      <Link href={href} passHref legacyBehavior>
        <Nav.Link className="px-3 py-2 d-flex align-items-center">
          {icon ? <FontAwesomeIcon className="nav-icon ms-n3" icon={icon} />
            : <span className="nav-icon ms-n3" />}
          {children}
        </Nav.Link>
      </Link>
    </Nav.Item>
  );
};

const SidebarNavTitle = (props: PropsWithChildren) => {
  const { children } = props;

  return (
    <li className="nav-title px-3 py-2 mt-3 text-uppercase fw-bold">{children}</li>
  );
};

export default function SidebarNav() {
  return (
    <ul className="list-unstyled">
      <SidebarNavItem icon={faGauge} href="/">
        Dashboard
        <small className="ms-auto"><Badge bg="info" className="ms-auto">NEW</Badge></small>
      </SidebarNavItem>

      <SidebarNavTitle>Projects</SidebarNavTitle>
      <SidebarNavItem icon={faList} href="/projects">List</SidebarNavItem>
      <SidebarNavItem icon={faPlus} href="/projects/create">Create</SidebarNavItem>
    </ul>
  );
}
